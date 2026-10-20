<?php
/**
 *
 * @fixture products
 * @fixture cards
 * @fixture related_cards
 * @fixture pricelist_items
 * @fixture warehouse_items
 */
class TcSellingAdvisor extends TcBase {

	function test_falls_back_to_related_cards_when_no_also_bought_data(){
		$coffee = $this->cards["coffee"];
		$tea = $this->cards["tea"];

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($coffee);

		$this->assertEquals([$tea->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function test_recommends_via_precomputed_also_bought_data(){
		list($a,$b) = $this->_makeOrderableCards(["A","B"]);
		$this->_insertAlsoBought($a,$b,10);

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([$b->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function test_also_bought_outranks_related_cards_fallback(){
		list($a,$b,$c) = $this->_makeOrderableCards(["A","B","C"]);
		$a->addRelatedCard($c); // weaker signal
		$this->_insertAlsoBought($a,$b,1); // stronger signal, even with a low raw score

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([$b->getId(),$c->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function test_accessories_and_consumables_outrank_plain_related_cards(){
		list($a,$accessory,$consumable,$related) = $this->_makeOrderableCards(["A","Accessory","Consumable","Related"]);
		$a->addRelatedCard($related);
		$a->addAccessory($accessory);
		$a->addConsumable($consumable);

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);
		$ids = array_map(function($c){ return $c->getId(); },$recs);

		$this->assertTrue(in_array($accessory->getId(),array_slice($ids,0,2)));
		$this->assertTrue(in_array($consumable->getId(),array_slice($ids,0,2)));
		$this->assertEquals($related->getId(),end($ids)); // plain related card ranks last
	}

	function test_boost_never_injects_an_unrelated_card(){
		list($a,$b,$c) = $this->_makeOrderableCards(["A","B","C"]);
		$a->addRelatedCard($b);
		CardRecommendationBoost::CreateNewRecord(["card_id" => $c]); // unrelated to $a

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([$b->getId()],array_map(function($card){ return $card->getId(); },$recs));
	}

	function test_boost_raises_an_already_relevant_candidate_to_the_top(){
		list($a,$b,$c) = $this->_makeOrderableCards(["A","B","C"]);
		$this->_insertAlsoBought($a,$b,10); // stronger raw also-bought signal
		$this->_insertAlsoBought($a,$c,1);
		CardRecommendationBoost::CreateNewRecord(["card_id" => $c]); // boosted, despite the lower score

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([$c->getId(),$b->getId()],array_map(function($card){ return $card->getId(); },$recs));
	}

	function test_negative_boost_suppresses_an_already_relevant_candidate(){
		list($a,$b,$c) = $this->_makeOrderableCards(["A","B","C"]);
		$this->_insertAlsoBought($a,$b,1); // weaker raw also-bought signal
		$this->_insertAlsoBought($a,$c,10); // stronger raw also-bought signal, but suppressed
		CardRecommendationBoost::CreateNewRecord(["card_id" => $c, "negative" => true]);

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([$b->getId(),$c->getId()],array_map(function($card){ return $card->getId(); },$recs));
	}

	function test_negative_boost_still_shows_up_when_there_is_no_better_candidate(){
		list($a,$only) = $this->_makeOrderableCards(["A","OnlyCandidate"]);
		$a->addRelatedCard($only); // the one and only candidate
		CardRecommendationBoost::CreateNewRecord(["card_id" => $only, "negative" => true]);

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		// a negative boost only deprioritizes within the ranking, it never hard-excludes
		$this->assertEquals([$only->getId()],array_map(function($card){ return $card->getId(); },$recs));
	}

	function test_negative_boost_never_excludes_an_unrelated_card(){
		list($a,$b,$c) = $this->_makeOrderableCards(["A","B","C"]);
		$a->addRelatedCard($b);
		CardRecommendationBoost::CreateNewRecord(["card_id" => $c, "negative" => true]); // unrelated to $a

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([$b->getId()],array_map(function($card){ return $card->getId(); },$recs));
	}

	function test_excludes_unorderable_candidates(){
		list($a) = $this->_makeOrderableCards(["A"]);
		$b = Card::CreateNewRecord(["name_cs" => "B", "name_en" => "B", "visible" => true, "deleted" => false]);
		Product::CreateNewRecord(["catalog_id" => "SA_NOPRICE_B", "card_id" => $b, "vat_rate_id" => VatRate::FindFirst()]); // no price, no stock
		$this->_insertAlsoBought($a,$b,10);

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([],$recs);
	}

	function test_anonymous_customer_does_not_crash(){
		list($a,$b) = $this->_makeOrderableCards(["A","B"]);
		$this->_insertAlsoBought($a,$b,10);

		$advisor = new SellingAdvisor(User::GetAnonymousUser());
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([$b->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function test_viewed_cards_accept_plain_ids_and_rank_below_the_primary_card(){
		list($a,$b,$x,$y) = $this->_makeOrderableCards(["A","B","X","Y"]);
		$this->_insertAlsoBought($a,$x,1); // primary card's own signal
		$this->_insertAlsoBought($b,$y,1); // merely viewed card's signal

		// $b is only "viewed", passed as a bare id (not a Card instance)
		$advisor = new SellingAdvisor(null,null,null,[$b->getId()]);
		$recs = $advisor->getRecommendedCardsForCard($a);

		// both X and Y show up, but X (via the primary card) outranks Y (via a viewed card)
		$this->assertEquals([$x->getId(),$y->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function test_customer_signals_are_dampened_for_a_card_anchored_query(){
		list($a,$w,$z,$basket_card,$viewed_card) = $this->_makeOrderableCards(["A","W","Z","InBasket","Viewed"]);

		// Z is reachable via both the basket card and the viewed card - its combined
		// score is large enough undamped to beat W, but not once dampened
		$this->_insertAlsoBought($basket_card,$z,1);
		$this->_insertAlsoBought($viewed_card,$z,1);

		// W is $a's own signal, pushed down to position 20 (weight 20) by 20 filler
		// entries inserted first - it sits strictly between Z's damped (4+2=6) and
		// full-strength (20+10=30) combined score
		for($i=0;$i<20;$i++){
			$this->_insertAlsoBought($a,Card::CreateNewRecord(["name_cs" => "Filler$i", "name_en" => "Filler$i", "visible" => true, "deleted" => false]),1);
		}
		$this->_insertAlsoBought($a,$w,1);

		$basket = new TcSellingAdvisorFakeBasket($basket_card->getFirstProduct());
		$advisor = new SellingAdvisor(null,$basket,null,[$viewed_card->getId()]);

		// by default, getRecommendedCardsForCard() dampens basket (4) and viewed (2) -
		// combined, Z scores 6, below W's 20
		$damped = array_map(function($c){ return $c->getId(); },$advisor->getRecommendedCardsForCard($a));
		$this->assertEquals([$w->getId(),$z->getId()],$damped);

		// at full strength (20+10=30 combined), Z would have outranked W instead
		$full_strength = array_map(function($c){ return $c->getId(); },$advisor->getRecommendedCardsForCard($a,[
			"basket_card_weight" => SellingAdvisor::BASKET_CARD_WEIGHT,
			"viewed_card_weight" => SellingAdvisor::VIEWED_CARD_WEIGHT,
		]));
		$this->assertEquals([$z->getId(),$w->getId()],$full_strength);
	}

	function test_favourite_bump_still_applies_when_dampened_for_a_card_anchored_query(){
		list($a,$plain,$favourite) = $this->_makeOrderableCards(["A","PlainRelated","FavouriteRelated"]);
		$a->addRelatedCard($plain);
		$a->addRelatedCard($favourite);

		$user = User::CreateNewRecord(["login" => "sa_fan", "email" => "sa_fan@example.com", "password" => "secret123"]);
		$fpa = new FavouriteProductsAccessor($user);
		$fpa->addProduct($favourite->getFirstProduct());

		$advisor = new SellingAdvisor($user,null,$fpa);
		$recs = $advisor->getRecommendedCardsForCard($a);

		// the dampened bonus is still enough to win a tie against an equally-ranked
		// (non-favourite) related card
		$this->assertEquals([$favourite->getId(),$plain->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function test_falls_back_to_best_sellers_when_there_is_no_primary_card_at_all(){
		list($a,$b) = $this->_makeOrderableCards(["A","B"]);
		$this->_insertBestSelling($a,20); // sells best
		$this->_insertBestSelling($b,5);

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCards();

		$this->assertEquals([$a->getId(),$b->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function test_best_sellers_fallback_does_not_apply_when_a_primary_card_is_given(){
		list($a,$b) = $this->_makeOrderableCards(["A","B"]);
		$this->_insertBestSelling($b,20); // unrelated to $a

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCardsForCard($a);

		$this->assertEquals([],$recs);
	}

	function test_best_sellers_enabled_option_can_suppress_the_fallback(){
		list($a) = $this->_makeOrderableCards(["A"]);
		$this->_insertBestSelling($a,20);

		$advisor = new SellingAdvisor();

		// getRecommendedCardsForCard(null) has no primary card, so best-sellers would
		// normally apply - best_sellers_enabled=false must suppress it regardless
		$this->assertEquals([$a->getId()],array_map(function($c){ return $c->getId(); },$advisor->getRecommendedCardsForCard(null)));
		$this->assertEquals([],$advisor->getRecommendedCardsForCard(null,["best_sellers_enabled" => false]));
	}

	function test_boost_applies_to_best_sellers_too(){
		list($a,$b) = $this->_makeOrderableCards(["A","B"]);
		$this->_insertBestSelling($a,20); // sells better...
		$this->_insertBestSelling($b,5);
		CardRecommendationBoost::CreateNewRecord(["card_id" => $b]); // ...but $b is boosted

		$advisor = new SellingAdvisor();
		$recs = $advisor->getRecommendedCards();

		$this->assertEquals([$b->getId(),$a->getId()],array_map(function($c){ return $c->getId(); },$recs));
	}

	function _makeOrderableCards($names){
		$vat = VatRate::FindFirst();
		$pricelist = Pricelist::FindFirst();
		$warehouse = Warehouse::FindFirst();

		return array_map(function($name) use ($vat,$pricelist,$warehouse){
			$card = Card::CreateNewRecord(["name_cs" => $name, "name_en" => $name, "visible" => true, "deleted" => false]);
			$product = Product::CreateNewRecord(["catalog_id" => "SA_".$name."_".$card->getId(), "card_id" => $card, "vat_rate_id" => $vat]);
			PricelistItem::CreateNewRecord(["pricelist_id" => $pricelist, "product_id" => $product, "minimum_quantity" => 0, "price" => 10]);
			$warehouse->addProduct($product,10);
			return $card;
		},$names);
	}

	function _insertAlsoBought($card,$related_card,$score){
		$dbmole = Card::GetDbmole();
		$dbmole->insertIntoTable("also_bought_cards",[
			"card_id" => $card->getId(),
			"related_card_id" => $related_card->getId(),
			"score" => $score,
			"rank" => 0,
		]);
	}

	function _insertBestSelling($card,$score){
		BestSellingCard::CreateNewRecord([
			"card_id" => $card,
			"score_last_year" => 0,
			"score_last_month" => 0,
			"score_last_week" => 0,
			"score_last_day" => 0,
			"score" => $score,
		]);
	}
}

class TcSellingAdvisorFakeBasketItem {
	function __construct($product){ $this->product = $product; }
	function getProduct(){ return $this->product; }
}

class TcSellingAdvisorFakeBasket {
	function __construct($product){ $this->items = array(new TcSellingAdvisorFakeBasketItem($product)); }
	function getBasketItems(){ return $this->items; }
}
