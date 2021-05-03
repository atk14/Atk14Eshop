<?php
/**
 *
 * @fixture cards
 * @fixture products
 * @fixture categories
 * @fixture category_cards
 */
class TcCategories extends TcBase {

	function assertCards($slugs_exp,$cards){
		$slugs = array_map(function($card){ return $card->getSlug(); },$cards);
		$this->assertEquals($slugs_exp,$slugs);
	}

	function test(){
		$client = $this->client;

		$client->get("categories/detail",["path" => $this->categories["hot_drinks"]->getPath()]);
		$this->assertCards(["coffee","tea"],$client->controller->finder->getRecords());

		$client->get("categories/detail",["path" => $this->categories["cold_drinks"]->getPath()]);
		$this->assertCards(["apple-cider"],$client->controller->finder->getRecords());

		$client->get("categories/detail",["path" => $this->categories["coffeine_drinks"]->getPath()]);
		$this->assertCards(["coffee","tea"],$client->controller->finder->getRecords());

		$client->get("categories/detail",["path" => $this->categories["food_drinks"]->getPath()]);
		$this->assertCards(["tea","apple-cider","coffee",],$client->controller->finder->getRecords());
	}
}
