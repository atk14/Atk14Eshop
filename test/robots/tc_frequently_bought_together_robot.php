<?php
/**
 * @fixture regions
 * @fixture delivery_methods
 * @fixture payment_methods
 * @fixture users
 */
class TcFrequentlyBoughtTogetherRobot extends TcBase {

	function test_run(){
		$card_a = Card::CreateNewRecord(["name_cs" => "Card A", "name_en" => "Card A"]);
		$product_a = Product::CreateNewRecord(["catalog_id" => "FBT_A", "card_id" => $card_a, "consider_stockcount" => false]);

		$card_b = Card::CreateNewRecord(["name_cs" => "Card B", "name_en" => "Card B"]);
		$product_b = Product::CreateNewRecord(["catalog_id" => "FBT_B", "card_id" => $card_b, "consider_stockcount" => false]);

		$card_c = Card::CreateNewRecord(["name_cs" => "Card C", "name_en" => "Card C"]);
		$product_c = Product::CreateNewRecord(["catalog_id" => "FBT_C", "card_id" => $card_c, "consider_stockcount" => false]);

		// rambo buys A in one order and B in a later order - a co-purchase across orders,
		// not within a single order, since that's the behavior the robot's query is for
		$order1 = $this->_createOrder(["user_id" => $this->users["rambo"]]);
		OrderItem::CreateNewRecord(["order_id" => $order1, "product_id" => $product_a, "amount" => 1, "unit_price_incl_vat" => 100]);

		$order2 = $this->_createOrder(["user_id" => $this->users["rambo"]]);
		OrderItem::CreateNewRecord(["order_id" => $order2, "product_id" => $product_b, "amount" => 1, "unit_price_incl_vat" => 200]);

		// rocky only ever buys C - he shouldn't introduce any pairing with A/B
		$order3 = $this->_createOrder(["user_id" => $this->users["rocky"]]);
		OrderItem::CreateNewRecord(["order_id" => $order3, "product_id" => $product_c, "amount" => 1, "unit_price_incl_vat" => 300]);

		$this->assertEquals(0,sizeof($this->_getAlsoBoughtCards($card_a)));

		$robot = new FrequentlyBoughtTogetherRobot();
		$robot->__runRobot();

		$a_related = $this->_getAlsoBoughtCards($card_a);
		$this->assertEquals(1,sizeof($a_related));
		$this->assertEquals($card_b->getId(),$a_related[0]["related_card_id"]);
		$this->assertEquals(1,$a_related[0]["score"]);

		$b_related = $this->_getAlsoBoughtCards($card_b);
		$this->assertEquals(1,sizeof($b_related));
		$this->assertEquals($card_a->getId(),$b_related[0]["related_card_id"]);

		$this->assertEquals(0,sizeof($this->_getAlsoBoughtCards($card_c)));
	}

	function _createOrder($values = []){
		return Order::CreateNewRecord($values + [
			"region_id" => $this->regions["czechoslovakia"],
			"delivery_method_id" => $this->delivery_methods["personal"],
			"delivery_fee_incl_vat" => 0,
			"payment_method_id" => $this->payment_methods["cash_on_delivery"],
			"payment_fee_incl_vat" => 79.0,
			"price_to_pay" => 100,
			"phone" => "+420.605111222",
		]);
	}

	function _getAlsoBoughtCards($card){
		return $this->dbmole->selectRows("
			SELECT related_card_id, score FROM also_bought_cards WHERE card_id=:card_id ORDER BY rank
		",[
			":card_id" => $card->getId(),
		]);
	}
}
