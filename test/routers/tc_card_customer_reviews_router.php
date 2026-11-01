<?php
/**
 * @fixture cards
 */
class TcCardCustomerReviewsRouter extends TcBase {

	function test(){
		$this->router = new CardCustomerReviewsRouter();

		// Building

		$uri = $this->assertBuildable([
			"lang" => "en",
			"controller" => "card_customer_reviews",
			"action" => "index",
			"card_id" => $this->cards["coffee"]->getId(),
		]);
		$this->assertEquals("/drink/coffee/reviews/",$uri);

		// Recognizing

		$params = [];
		$ret = $this->assertRecognizable("/drink/coffee/reviews/",$params);
		$this->assertEquals("card_customer_reviews",$ret["controller"]);
		$this->assertEquals("index",$ret["action"]);
		$this->assertEquals("en",$ret["lang"]);
		$this->assertEquals($this->cards["coffee"]->getId(),$params["card_id"]);

		$this->assertNotRecognizable("/drink/coffee/");

		$this->assertNotRecognizable("/non-existing-card/reviews/");
	}
}
