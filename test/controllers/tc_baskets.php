<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 * @fixture warehouse_items
 */
class TcBaskets extends TcBase {

	function test(){
		global $HTTP_REQUEST;
		$HTTP_REQUEST->setRemoteAddr("127.0.0.1");

		$client = $this->client;
		$mint_tea = $this->products["mint_tea"];

		$controller = $client->get("main/index");
		$basket = $controller->_get_basket(true);
		$this->assertTrue($basket->isEmpty());

		$controller = $client->post("baskets/add_product",[
			"product_id" => $mint_tea->getId(),
			"amount" => 2,
		]);
		$basket = $controller->_get_basket();
		$items = $basket->getItems();
		$this->assertEquals(1,sizeof($items));
		$this->assertEquals($mint_tea->getId(),$items[0]->getProductId());
		$this->assertEquals(2,$items[0]->getAmount());

		$controller = $client->post("baskets/add_product",[
			"product_id" => $mint_tea->getId(),
			"amount" => 3,
		]);
		$basket = $controller->_get_basket();
		$this->assertFalse($basket->isEmpty());
		$items = $basket->getItems();
		$this->assertEquals(1,sizeof($items));
		$this->assertEquals($mint_tea->getId(),$items[0]->getProductId());
		$this->assertEquals(5,$items[0]->getAmount()); // 2 + 3

		$controller = $client->post("baskets/set_product_amount",[
			"product_id" => $mint_tea->getId(),
			"amount" => 3,
		]);
		$basket = $controller->_get_basket();
		$this->assertFalse($basket->isEmpty());
		$items = $basket->getItems();
		$this->assertEquals(1,sizeof($items));
		$this->assertEquals($mint_tea->getId(),$items[0]->getProductId());
		$this->assertEquals(3,$items[0]->getAmount()); // 5 -> 3
	}
}
