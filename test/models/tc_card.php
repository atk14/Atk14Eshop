<?php
/**
 *
 * @fixture products
 * @fixture cards
 * @fixture categories
 * @fixture category_cards
 * @fixture technical_specification_keys
 * @fixture technical_specifications
 * @fixture pricelist_items
 * @fixture warehouse_items
 * @fixture related_cards
 * @fixture consumables
 * @fixture accessories
 */
class TcCard extends TcBase {

	function assertCategories($paths_exp,$categories){
		$paths = array_map(function($category){ return $category->getPath(); },$categories);
		$this->assertEquals($paths_exp,$paths);
	}

	function test(){
		$tea = $this->cards["tea"];
		$catalog = $this->categories["catalog"];
		$food_drinks = $this->categories["food_drinks"];
		$color = $this->categories["color"];
		$color_green = $this->categories["color_green"];
		$hot_drinks = $this->categories["hot_drinks"];
		$coffeine_drinks = $this->categories["coffeine_drinks"];

		// Testing Card::getCategories()

		$categories = $tea->getCategories();
		$this->assertCategories([
			'catalog/food-drinks',
			'catalog/food-drinks/hot-drinks',
			'catalog/food-drinks/coffeine-drinks',
			'catalog/color/green',
		],$categories);

		$categories = $tea->getCategories(array("consider_filters" => false));
		$this->assertCategories([
			'catalog/food-drinks',
			'catalog/food-drinks/hot-drinks',
			'catalog/food-drinks/coffeine-drinks',
		],$categories);

		$categories = $tea->getCategories(array("consider_filters" => false, "deduplicate" => true));
		$this->assertCategories([
			'catalog/food-drinks/hot-drinks',
			'catalog/food-drinks/coffeine-drinks',
		],$categories);

		$categories = $tea->getCategories(array("root_category" => $catalog));
		$this->assertEquals(4,sizeof($categories));

		$categories = $tea->getCategories(array("root_category" => $food_drinks));
		$this->assertEquals(3,sizeof($categories));

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

	function test_isViewableInEshop(){
		$coffee = $this->cards["coffee"];
		$this->assertEquals(true,$coffee->isViewableInEshop());

		$coffee->s("visible",false);
		$this->assertEquals(true,$coffee->isViewableInEshop());

		$coffee->s("deleted",true);
		$this->assertEquals(true,$coffee->isViewableInEshop());

		$price_rounding = Product::FindByCode("price_rounding");
		$this->assertEquals(false,$price_rounding->getCard()->isViewableInEshop());
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

	function test_GetFinderForCategory(){
		$catalog = $this->categories["catalog"];

		$finder = Card::GetFinderForCategory($catalog);
		$this->assertTrue($finder->getTotalAmount()>0);

		$finder = Card::GetFinderForCategory($catalog,array(),array("search_entire_branch" => false));
		$this->assertTrue($finder->getTotalAmount()===0);
	}

	function test_getTechnicalSpecifications(){
		$coffee = $this->cards["coffee"];

		$technical_specifications = $coffee->getTechnicalSpecifications();
		$this->assertEquals(5,sizeof($technical_specifications));
		$this->assertEquals(["aroma","weight","acidity","producer_code","decaffeinated"],array_map(function($ts){ return $ts->getTechnicalSpecificationKey()->g("key"); },$technical_specifications));

		$technical_specifications = $coffee->getTechnicalSpecifications(["visible" => true]);
		$this->assertEquals(4,sizeof($technical_specifications));
		$this->assertEquals(["aroma","weight","acidity","decaffeinated"],array_map(function($ts){ return $ts->getTechnicalSpecificationKey()->g("key"); },$technical_specifications));

		$this->assertEquals("Strong",(string)$coffee->getTechnicalSpecification("aroma"));
		$this->assertEquals("200g",(string)$coffee->getTechnicalSpecification($this->technical_specification_keys["weight"]));
		$this->assertEquals("Low",(string)$coffee->getTechnicalSpecification($this->technical_specification_keys["acidity"]->getId()));
		$this->assertEquals("No",(string)$coffee->getTechnicalSpecification($this->technical_specification_keys["decaffeinated"]->getId()));
		$this->assertEquals("No",(string)$coffee->getTechnicalSpecification("decaffeinated"));
		$this->assertEquals("No",(string)$coffee->getTechnicalSpecification("decaffeinated_code"));
		$this->assertEquals(null,$coffee->getTechnicalSpecification("width"));
	}

	function test_getPrimaryCategory(){
		$coffee = $this->cards["coffee"];

		$primary_category = $coffee->getPrimaryCategory();
		$this->assertNotNull($primary_category);
		$this->assertEquals("Hot drinks",$primary_category->getName());

		$this->categories["hot_drinks"]->s("visible",false);
		Cache::Clear();

		$primary_category = $coffee->getPrimaryCategory();
		$this->assertNotNull($primary_category);
		$this->assertEquals("Coffeine drinks",$primary_category->getName());

		$primary_category = $coffee->getPrimaryCategory(["consider_invisible_categories" => true]);
		$this->assertNotNull($primary_category);
		$this->assertEquals("Hot drinks",$primary_category->getName());
	}

	function test_isIndexable(){
		$coffee = $this->cards["coffee"];

		$this->assertTrue($coffee->isIndexable());
		
		$coffee->getCategoriesLister()->setRecords(array());
		$this->assertFalse($coffee->isIndexable());

		$coffee->getCategoriesLister()->setRecords(array($this->categories["hidden"]));
		$this->assertFalse($coffee->isIndexable());

		$coffee->getCategoriesLister()->setRecords(array($this->categories["hidden"],$this->categories["hot_drinks"]));
		$this->assertTrue($coffee->isIndexable());
	}
}
