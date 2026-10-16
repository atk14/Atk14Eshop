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
}
