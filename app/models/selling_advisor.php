<?php
/**
 * Cross-sell / "customers who bought this also bought" recommendations.
 *
 * Request-scoped on the customer context (constructor); what's actually being
 * asked about - a card, a category, or nothing but basket contents - is passed
 * per call, so one instance can be reused across several widgets in one request.
 *
 * ```
 * $advisor = new SellingAdvisor($this->logged_user, $this->basket, $this->favourite_products_accessor, $viewed_cards);
 * $advisor->getRecommendedCardsForCard($card);
 * $advisor->getRecommendedCardsForCategory($category);
 * $advisor->getRecommendedCards(); // basket-only, e.g. on the basket page
 * ```
 */
class SellingAdvisor {

	protected $customer;
	protected $basket;
	protected $favourite_products_accessor;
	protected $viewed_cards;

	function __construct($customer = null, $basket = null, $favourite_products_accessor = null, $viewed_cards = array()) {
		// User::GetAnonymousUser() is a real, truthy object (not null) - without this,
		// a caller passing e.g. $this->effective_user instead of $this->logged_user would
		// make us build a session-less FavouriteProductsAccessor below and crash on a null session
		if ($customer && $customer->isAnonymous()) {
			$customer = null;
		}

		$this->customer = $customer;
		$this->basket = $basket;
		$this->favourite_products_accessor = $favourite_products_accessor;
		$this->viewed_cards = $viewed_cards;
	}

	/**
	 * Recommendations anchored on a specific card (e.g. the card detail page).
	 *
	 * $options: see getRecommendedCards()
	 */
	function getRecommendedCardsForCard($card, $options = array()) {
		return $this->_getRecommendedCards($card ? array($card) : array(), array(), $options);
	}

	/**
	 * Recommendations anchored on a category (e.g. a category listing page with no
	 * single card to build around).
	 *
	 * $options: see getRecommendedCards()
	 */
	function getRecommendedCardsForCategory($category, $options = array()) {
		return $this->_getRecommendedCards(array(), $category ? array($category) : array(), $options);
	}

	/**
	 * General entry point - no specific card/category anchor required, e.g. purely
	 * from basket contents (the basket page) or just the product just added to it
	 * (the "added to basket" confirmation modal).
	 *
	 * Blends several sources, by priority, each only filling in slots the previous
	 * one left empty:
	 *   1. precomputed co-purchase data (see Card::getViewableAlsoBoughtCards()),
	 *      blended across every primary card (getRecommendedCardsForCard()'s card,
	 *      plus product_just_added_to_basket's card if given) and every card already
	 *      in the basket
	 *   2. the primary cards' manually curated related cards (Card::getViewableRelatedCards())
	 *   3. the primary cards' primary categories' manually curated recommended cards,
	 *      plus getRecommendedCardsForCategory()'s category if given
	 *
	 * A card from the admin-managed boost list (CardRecommendationBoost) gets its
	 * score bumped up *if it is already a candidate from one of the sources above* -
	 * the boost list never pulls in an otherwise unrelated card on its own.
	 *
	 * Candidates already among the customer's favourite products (via the
	 * favourite_products_accessor/customer given to the constructor) get a small
	 * extra bump.
	 *
	 * Every candidate must have at least one orderable product (in stock, with a
	 * resolvable price - see Product::canBeOrdered()); everything else is discarded.
	 *
	 * $options:
	 *   product_just_added_to_basket Product  the product variant that was just added
	 *                          to the basket (e.g. for the "added to basket" success
	 *                          modal) - its card is treated as a primary card, with a
	 *                          stronger also-bought signal than plain basket contents,
	 *                          and is always excluded from the result
	 *   limit         int      how many cards to return at most (default 8)
	 *   exclude_cards Card[]   extra cards to never suggest
	 *   price_finder  PriceFinder  defaults to PriceFinder::GetCurrentInstance()
	 *
	 * The viewed_cards given to the constructor are reserved for a future ranking
	 * signal - accepted, but not used yet.
	 */
	function getRecommendedCards($options = array()) {
		return $this->_getRecommendedCards(array(), array(), $options);
	}

	protected function _getRecommendedCards($primary_cards, $fallback_categories, $options) {
		$options = array_merge(array(
			"product_just_added_to_basket" => null,
			"limit" => 8,
			"exclude_cards" => array(),
			"price_finder" => null,
		), $options);

		$price_finder = $options["price_finder"] ?: PriceFinder::GetCurrentInstance();
		$is_orderable = function ($card) use ($price_finder) {
			return $card->canBeOrdered(array("price_finder" => $price_finder));
		};

		$primary_cards_by_id = array();
		foreach ($primary_cards as $c) {
			$primary_cards_by_id[$c->getId()] = $c;
		}
		if ($options["product_just_added_to_basket"]) {
			$c = $options["product_just_added_to_basket"]->getCard();
			$primary_cards_by_id[$c->getId()] = $c;
		}

		$fallback_categories_by_id = array();
		foreach ($fallback_categories as $category) {
			$fallback_categories_by_id[$category->getId()] = $category;
		}
		foreach ($primary_cards_by_id as $primary_card) {
			if ($category = $primary_card->getPrimaryCategory()) {
				$fallback_categories_by_id[$category->getId()] = $category;
			}
		}

		$exclude_ids = array_keys($primary_cards_by_id);
		foreach ($options["exclude_cards"] as $c) {
			$exclude_ids[] = TableRecord::ObjToId($c);
		}

		$source_cards = $primary_cards_by_id;
		if ($this->basket) {
			foreach ($this->basket->getBasketItems() as $item) {
				$card = $item->getProduct()->getCard();
				$exclude_ids[] = $card->getId();
				$source_cards[$card->getId()] = $card;
			}
		}
		$exclude_ids = array_unique($exclude_ids);

		$scores = array(); // candidate_card_id => score

		foreach ($source_cards as $source_card) {
			$is_primary = isset($primary_cards_by_id[$source_card->getId()]);
			$position = 0;
			foreach ($source_card->getViewableAlsoBoughtCards() as $candidate) {
				$weight = max(1, ($is_primary ? 40 : 20) - $position);
				$position++;
				if (in_array($candidate->getId(), $exclude_ids)) { continue; }
				if (!$is_orderable($candidate)) { continue; }
				$scores[$candidate->getId()] = ($scores[$candidate->getId()] ?? 0) + $weight;
			}
		}

		if (sizeof($scores) < $options["limit"]) {
			foreach ($primary_cards_by_id as $primary_card) {
				foreach ($primary_card->getViewableRelatedCards() as $candidate) {
					if (in_array($candidate->getId(), $exclude_ids)) { continue; }
					if (!$is_orderable($candidate)) { continue; }
					if (!isset($scores[$candidate->getId()])) {
						$scores[$candidate->getId()] = 0; // present, but below any real purchase signal
					}
				}
			}
		}

		if (sizeof($scores) < $options["limit"]) {
			foreach ($fallback_categories_by_id as $category) {
				foreach ($category->getRecommendedCards() as $candidate) {
					if (!$candidate->isViewableInEshop() || !$candidate->isVisible()) { continue; }
					if (in_array($candidate->getId(), $exclude_ids)) { continue; }
					if (!$is_orderable($candidate)) { continue; }
					if (!isset($scores[$candidate->getId()])) {
						$scores[$candidate->getId()] = -1; // lowest priority fallback
					}
				}
			}
		}

		if ($scores) {
			foreach (CardRecommendationBoost::GetBoostedCardIds() as $boosted_id => $_) {
				if (isset($scores[$boosted_id])) {
					$scores[$boosted_id] += 1000;
				}
			}
		}

		$fpa = $this->favourite_products_accessor;
		if (!$fpa && $this->customer) {
			$fpa = new FavouriteProductsAccessor($this->customer);
		}
		if ($scores && $fpa) {
			foreach (Cache::Get("Card", array_keys($scores)) as $candidate) {
				if ($candidate && $fpa->isFavouriteCard($candidate)) {
					$scores[$candidate->getId()] += 10;
				}
			}
		}

		if (!$scores) { return array(); }

		arsort($scores);
		$ids = array_slice(array_keys($scores), 0, $options["limit"]);

		return array_values(array_filter(Cache::Get("Card", $ids)));
	}
}
