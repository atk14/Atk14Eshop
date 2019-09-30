<?php
/**
 *
 * @fixture cards
 * @fixture products
 */
class TcCards extends TcBase {

	function test(){
		$client = $this->client;
	
		// Normal product
		$card = $this->cards["coffee"];
		$client->get("cards/detail",["id" => $card]);
		$this->assertEquals(200,$client->getStatusCode());
		$this->assertContains($card->getName(),$client->getContent());

		// Invisible product
		$card->s("visible",false);
		$client->get("cards/detail",["id" => $card]);
		$this->assertEquals(404,$client->getStatusCode());
		$this->assertContains($card->getName(),$client->getContent());

		// Special system product
		$product = Product::FindByCode("price_rounding");
		$card = $product->getCard();
		$client->get("cards/detail",["id" => $card]);
		$this->assertEquals(404,$client->getStatusCode());
		$this->assertNotContains($card->getName(),$client->getContent());
	}
}
