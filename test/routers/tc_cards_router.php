<?php
/**
 *
 * @fixture product_types
 * @fixture cards
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

		// Uri with another slug of product type is recognizable also
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
	}
}
