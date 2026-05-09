<?php
/**
 *
 * @fixture product_types
 * @fixture cards
 * @fixture products
 */
class TcCardsRouter extends TcBase {

	function test(){
		$this->router = new CardsRouter();

		// Building

		$uri = $this->assertBuildable(array(
			"lang" => "en",
			"controller" => "cards",
			"action" => "detail",
			"id" => $this->cards["book"]->getId(),
		));
		$this->assertEquals("/book/the-book/",$uri);

		$uri = $this->assertBuildable(array(
			"lang" => "cs",
			"controller" => "cards",
			"action" => "detail",
			"id" => $this->cards["book"]->getId(),
		));
		$this->assertEquals("/kniha/ta-kniha/",$uri);

		$uri = $this->assertBuildable(array(
			"lang" => "en",
			"controller" => "cards",
			"action" => "detail",
			"id" => $this->cards["coffee"]->getId(),
		));
		$this->assertEquals("/drink/coffee/",$uri);

		// card with a variant (product_id)
		$uri = $this->assertBuildable(array(
			"lang" => "en",
			"controller" => "cards",
			"action" => "detail",
			"id" => $this->cards["tea"]->getId(),
			"product_id" => $this->products["green_tea"]->getId(),
		));
		$this->assertEquals("/drink/tea/green/",$uri);

		// card with a wrong variant (a product from a different card)
		// -> the product's slug "green" can't be used because it is in a different slug segment
		$uri = $this->assertBuildable(array(
			"lang" => "en",
			"controller" => "cards",
			"action" => "detail",
			"id" => $this->cards["peanuts"]->getId(),
			"product_id" => $this->products["green_tea"]->getId(),
		));
		$this->assertEquals("/product/peanuts/products-en-{$this->products["green_tea"]->getId()}/",$uri);

		// not existing card
		$this->assertNotBuildable(array(
			"lang" => "en",
			"controller" => "cards",
			"action" => "detail",
			"id" => 1234,
		));

		// Recognizing

		$params = array();
		$ret = $this->assertRecognizable("/book/the-book/",$params);
		$this->assertEquals("cards",$ret["controller"]);
		$this->assertEquals("detail",$ret["action"]);
		$this->assertEquals("en",$ret["lang"]);
		$this->assertEquals($this->cards["book"]->getId(),$params["id"]);

		$params = array();
		$ret = $this->assertRecognizable("/kniha/ta-kniha/",$params);
		$this->assertEquals("cards",$ret["controller"]);
		$this->assertEquals("detail",$ret["action"]);
		$this->assertEquals("cs",$ret["lang"]);
		$this->assertEquals($this->cards["book"]->getId(),$params["id"]);

		// URI with another slug of product type is recognizable also
		$params = array();
		$ret = $this->assertRecognizable("/drink/the-book/",$params);
		$this->assertEquals("cards",$ret["controller"]);
		$this->assertEquals("detail",$ret["action"]);
		$this->assertEquals("en",$ret["lang"]);
		$this->assertEquals($this->cards["book"]->getId(),$params["id"]);

		$params = array();
		$ret = $this->assertRecognizable("/napoj/ta-kniha/",$params);
		$this->assertEquals("cards",$ret["controller"]);
		$this->assertEquals("detail",$ret["action"]);
		$this->assertEquals("cs",$ret["lang"]);
		$this->assertEquals($this->cards["book"]->getId(),$params["id"]);
	
		// Both slugs needs to be in the same language
		$this->assertNotRecognizable("/book/ta-kniha/");
		$this->assertNotRecognizable("/napoj/the-book/");
		$this->assertNotRecognizable("/drink/ta-kniha/");

		// URI without the trailing slash
		$params = array();
		$ret = $this->assertRecognizable("/kniha/ta-kniha",$params);
		$this->assertEquals("cards",$ret["controller"]);
		$this->assertEquals("detail",$ret["action"]);
		$this->assertEquals("cs",$ret["lang"]);
		$this->assertEquals($this->cards["book"]->getId(),$params["id"]);

		// Link to a card with a variant
		foreach(array(
			"/napoj/caj/cerny/",
			"/napoj/caj/cerny", // missing the trailing slash
		) as $uri){
			$params = array();
			$ret = $this->assertRecognizable($uri,$params);
			$this->assertEquals("cards",$ret["controller"]);
			$this->assertEquals("detail",$ret["action"]);
			$this->assertEquals("cs",$ret["lang"]);
			$this->assertEquals($this->cards["tea"]->getId(),$params["id"]);
			$this->assertEquals($this->products["black_tea"]->getId(),$params["product_id"]);
		}
	}
}
