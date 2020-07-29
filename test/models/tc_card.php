<?php
/**
 *
 * @fixture products
 * @fixture cards
 * @fixture categories
 * @fixture category_cards
 * @fixture pricelist_items
 * @fixture warehouse_items
 * @fixture related_cards
 * @fixture consumables
 * @fixture accessories
 */
class TcCard extends TcBase {

	function test(){
		$tea = $this->cards["tea"];
		$catalog = $this->categories["catalog"];
		$food_drinks = $this->categories["food_drinks"];
		$color = $this->categories["color"];
		$color_green = $this->categories["color_green"];
		$hot_drinks = $this->categories["hot_drinks"];

		// Testing Card::getCategories()

		$categories = $tea->getCategories();
		$this->assertEquals(3,sizeof($categories));
		$this->assertEquals($color_green->getId(),$categories[0]->getId());
		$this->assertEquals($food_drinks->getId(),$categories[1]->getId());
		$this->assertEquals($hot_drinks->getId(),$categories[2]->getId());

		$categories = $tea->getCategories(array("consider_filters" => false));
		$this->assertEquals(2,sizeof($categories));
		$this->assertEquals($food_drinks->getId(),$categories[0]->getId());
		$this->assertEquals($hot_drinks->getId(),$categories[1]->getId());

		$categories = $tea->getCategories(array("consider_filters" => false, "deduplicate" => true));
		$this->assertEquals(1,sizeof($categories));
		$this->assertEquals($hot_drinks->getId(),$categories[0]->getId());

		$categories = $tea->getCategories(array("root_category" => $catalog));
		$this->assertEquals(3,sizeof($categories));

		$categories = $tea->getCategories(array("root_category" => $food_drinks));
		$this->assertEquals(2,sizeof($categories));

		$categories = $tea->getCategories(array("filters_only" => true));
		$this->assertEquals(1,sizeof($categories));
		$this->assertEquals($color_green->getId(),$categories[0]->getId());

		// Testing Card::getActiveFilters()

		$filters = $tea->getActiveFilters();
		$this->assertEquals(1,sizeof($filters));
		$this->assertEquals($color->getId(),$filters[0]->getId());
	}

	function test_canBeSwitchedToNonVariantMode(){
		$card = Card::CreateNewRecord(array());
		$this->assertTrue($card->canBeSwitchedToNonVariantMode());

		$card = Card::CreateNewRecord(array());
		$card->createProduct(array("catalog_id" => "123"));
		$this->assertTrue($card->canBeSwitchedToNonVariantMode());

		$card = Card::CreateNewRecord(array());
		$card->createProduct(array("catalog_id" => "124"));
		$card->createProduct(array("catalog_id" => "125"));
		$this->assertFalse($card->canBeSwitchedToNonVariantMode());

		$card = Card::CreateNewRecord(array());
		$card->createProduct(array("catalog_id" => "126"));
		$card->createProduct(array("catalog_id" => "127","deleted" => true));
		$this->assertTrue($card->canBeSwitchedToNonVariantMode());

		$products = $card->getProducts();
		$this->assertEquals(1,sizeof($products));
		$products[0]->s("visible",false);
		$this->assertFalse($card->canBeSwitchedToNonVariantMode());
	}

	function test_canBeOrdered(){
		$tea = $this->cards["tea"];
		$this->assertEquals(true,$tea->canBeOrdered());

		foreach($tea->getProducts() as $p){
			$p->s("visible",false);
		}
		$this->assertEquals(false,$tea->canBeOrdered());
	}

	function test_getRelatedCards() {
		$this->assertCount(1, $this->cards["coffee"]->getRelatedCards());
		$this->assertCount(0, $this->cards["tea"]->getRelatedCards());
		$this->assertCount(1, $this->cards["coffee"]->getViewableRelatedCards());
		$this->assertCount(0, $this->cards["tea"]->getViewableRelatedCards());

		$this->cards["tea"]->s("visible", false);
		Cache::Clear();
		$this->assertCount(1, $this->cards["coffee"]->getRelatedCards());
		$this->assertCount(0, $this->cards["tea"]->getRelatedCards());
		$this->assertCount(0, $this->cards["coffee"]->getViewableRelatedCards());
		$this->assertCount(0, $this->cards["tea"]->getViewableRelatedCards());
	}

	function test_getConsumables() {
		$this->assertCount(1, $this->cards["coffee"]->getConsumables());
		$this->assertCount(0, $this->cards["tea"]->getConsumables());
		$this->assertCount(1, $this->cards["coffee"]->getViewableConsumables());
		$this->assertCount(0, $this->cards["tea"]->getViewableConsumables());

		$this->cards["tea"]->s("visible", false);
		Cache::Clear();
		$this->assertCount(1, $this->cards["coffee"]->getConsumables());
		$this->assertCount(0, $this->cards["tea"]->getConsumables());
		$this->assertCount(0, $this->cards["coffee"]->getViewableConsumables());
		$this->assertCount(0, $this->cards["tea"]->getViewableConsumables());
	}

	function test_getAccessories() {
		$this->assertCount(1, $this->cards["coffee"]->getAccessories());
		$this->assertCount(0, $this->cards["book"]->getAccessories());
		$this->assertCount(1, $this->cards["coffee"]->getViewableAccessories());
		$this->assertCount(0, $this->cards["book"]->getViewableAccessories());

		$this->cards["book"]->s("visible", false);
		Cache::Clear();
		$this->assertCount(1, $this->cards["coffee"]->getAccessories());
		$this->assertCount(0, $this->cards["book"]->getAccessories());
		$this->assertCount(0, $this->cards["coffee"]->getViewableAccessories());
		$this->assertCount(0, $this->cards["book"]->getViewableAccessories());
	}
}
