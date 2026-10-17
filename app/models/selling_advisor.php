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

	const PRIMARY_CARD_WEIGHT = 40;
	const BASKET_CARD_WEIGHT = 20;
	const VIEWED_CARD_WEIGHT = 10;
	const FAVOURITE_BONUS = 10;

	// getRecommendedCardsForCard() multiplies all three "signals about the customer in
	// general" above by this factor (the primary card's own weight is untouched) - at
	// full strength they'd make every product page's "also bought" widget look the same
	// (whatever's in the cart/favourites/browsing history) instead of being specific to
	// the card actually being looked at
	const CUSTOMER_SIGNAL_DAMPING_COEFFICIENT = 0.2;

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

		// $viewed_cards may contain a mix of Card instances and bare card ids - internally
		// we only ever keep plain ids, resolving to Card instances lazily where needed
		$this->viewed_cards = TableRecord::ObjToId($viewed_cards);
	}

	/**
	 * Recommendations anchored on a specific card (e.g. the card detail page).
	 *
	 * The basket/viewed/favourites signals are dampened here (see
	 * CUSTOMER_SIGNAL_DAMPING_COEFFICIENT) so the result stays specific to $card instead
	 * of just reflecting whatever the customer already has in their basket, favourites
	 * or browsing history on every product page.
	 *
	 * $options: see getRecommendedCards()
	 */
	function getRecommendedCardsForCard($card, $options = array()) {
		$options += array(
			"basket_card_weight" => self::BASKET_CARD_WEIGHT * self::CUSTOMER_SIGNAL_DAMPING_COEFFICIENT,
			"viewed_card_weight" => self::VIEWED_CARD_WEIGHT * self::CUSTOMER_SIGNAL_DAMPING_COEFFICIENT,
			"favourite_bonus" => self::FAVOURITE_BONUS * self::CUSTOMER_SIGNAL_DAMPING_COEFFICIENT,
		);
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
	 *   1. precomputed co-purchase data (see Card::getViewableAlsoBoughtCards()), blended
	 *      across every primary card (getRecommendedCardsForCard()'s card, plus
	 *      product_just_added_to_basket's card if given), every card already in the
	 *      basket, and - weighted weaker still - the viewed_cards given to the
	 *      constructor (a card already covered by a stronger source keeps that source's
	 *      weight instead of being counted twice)
	 *   2. the primary cards' manually curated accessories and consumables
	 *      (Card::getViewableAccessories()/getViewableConsumables()) - a more specific,
	 *      near-certain add-on signal, so it outranks the looser "related cards" below
	 *   3. the primary cards' manually curated related cards (Card::getViewableRelatedCards())
	 *   4. the primary cards' primary categories' manually curated recommended cards,
	 *      plus getRecommendedCardsForCategory()'s category if given
	 *   5. only when there's no primary card at all (e.g. a bare getRecommendedCards()
	 *      call with an empty basket and no product_just_added_to_basket): the
	 *      precomputed global best-sellers (see BestSellingCard) - the true last resort
	 *      for a visitor with no browsing/purchase history to go on
	 *
	 * A card from the admin-managed boost list (CardRecommendationBoost) gets its score
	 * adjusted up or down (a "negative" boost suppresses it) *if it is already a
	 * candidate from one of the sources above* - the boost list never pulls in an
	 * otherwise unrelated card, nor hard-excludes one.
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
			"basket_card_weight" => self::BASKET_CARD_WEIGHT,
			"viewed_card_weight" => self::VIEWED_CARD_WEIGHT,
			"favourite_bonus" => self::FAVOURITE_BONUS,
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

		// base also-bought weight per source card id, by how strong a signal of intent it
		// is: primary (the thing being viewed/just bought) > basket contents > merely
		// viewed cards; ids only here, resolved to Card instances in one batch below
		$source_weights = array();

		foreach (array_keys($primary_cards_by_id) as $id) {
			$source_weights[$id] = self::PRIMARY_CARD_WEIGHT;
		}

		if ($this->basket) {
			foreach ($this->basket->getBasketItems() as $item) {
				$id = $item->getProduct()->getCardId();
				$exclude_ids[] = $id;
				if (!isset($source_weights[$id])) {
					$source_weights[$id] = $options["basket_card_weight"];
				}
			}
		}

		foreach ($this->viewed_cards as $id) {
			if (!isset($source_weights[$id])) {
				$source_weights[$id] = $options["viewed_card_weight"];
			}
		}

		$exclude_ids = array_unique($exclude_ids);

		$source_cards = array_filter(Cache::Get("Card", array_keys($source_weights)));

		$scores = array(); // candidate_card_id => score

		foreach ($source_cards as $source_card) {
			$base_weight = $source_weights[$source_card->getId()];
			$position = 0;
			foreach ($source_card->getViewableAlsoBoughtCards() as $candidate) {
				$weight = max(1, $base_weight - $position);
				$position++;
				if (in_array($candidate->getId(), $exclude_ids)) { continue; }
				if (!$is_orderable($candidate)) { continue; }
				$scores[$candidate->getId()] = ($scores[$candidate->getId()] ?? 0) + $weight;
			}
		}

		if (sizeof($scores) < $options["limit"]) {
			foreach ($primary_cards_by_id as $primary_card) {
				$add_ons = array_merge($primary_card->getViewableAccessories(), $primary_card->getViewableConsumables());
				foreach ($add_ons as $candidate) {
					if (in_array($candidate->getId(), $exclude_ids)) { continue; }
					if (!$is_orderable($candidate)) { continue; }
					if (!isset($scores[$candidate->getId()])) {
						$scores[$candidate->getId()] = 1; // a specific curated add-on, stronger than a plain "related" card
					}
				}
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

		if (sizeof($scores) < $options["limit"] && !$primary_cards_by_id) {
			foreach (BestSellingCard::GetCards() as $candidate) {
				if (in_array($candidate->getId(), $exclude_ids)) { continue; }
				if (!$is_orderable($candidate)) { continue; }
				if (!isset($scores[$candidate->getId()])) {
					$scores[$candidate->getId()] = -2; // the true last resort
				}
			}
		}

		if ($scores) {
			foreach (CardRecommendationBoost::GetScoreAdjustments() as $boosted_id => $adjustment) {
				if (isset($scores[$boosted_id])) {
					$scores[$boosted_id] += $adjustment;
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
					$scores[$candidate->getId()] += $options["favourite_bonus"];
				}
			}
		}

		if (!$scores) { return array(); }

		arsort($scores);
		$ids = array_slice(array_keys($scores), 0, $options["limit"]);

		return array_values(array_filter(Cache::Get("Card", $ids)));
	}
}
