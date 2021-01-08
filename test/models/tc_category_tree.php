<?php
/**
 *
 * @fixture categories
 * @fixture category_cards
 */
class TcCategoryTree extends TcBase {

	function test(){
		$root = Category::FindByCode("catalog");

		$tree = CategoryTree::GetInstance($root);
		$this->assertEquals(true,$tree->hasChilds());

		$nodes = $tree->getChildNodes();
		$this->assertEquals(4,sizeof($nodes));

		$categories = $tree->getChildCategories();
		$this->assertEquals(4,sizeof($categories));

		$paths = array_map(function($node){ return $node->getPath(); },$nodes[0]->getChildNodes());
		$this->assertEquals(array(
			"catalog/color/red",
			"catalog/color/green",
			"catalog/color/yellow",
			"catalog/color/blue",
		),$paths);

		$paths = array_map(function($node){ return $node->getPath(); },$nodes[1]->getChildNodes());
		$this->assertEquals(array(
			"catalog/usage/outdoor",
			"catalog/usage/indoor",
		),$paths);

		$paths = array_map(function($node){ return $node->getPath(); },$nodes[2]->getChildNodes());
		$this->assertEquals(array(
			"catalog/food-drinks/hot-drinks",
			"catalog/food-drinks/cold-drinks"
		),$paths);

		$paths = array_map(function($node){ return $node->getPath(); },$nodes[3]->getChildNodes());
		$this->assertEquals(array(
			"catalog/shoes/kids",
			"catalog/shoes/men"
		),$paths);

		// disaloving filters

		$tree = CategoryTree::GetInstance($root,array("is_filter" => false));

		$nodes = $tree->getChildNodes();
		$this->assertEquals(2,sizeof($nodes));

		$paths = array_map(function($node){ return $node->getPath(); },$nodes[0]->getChildNodes());
		$this->assertEquals(array(
			"catalog/food-drinks/hot-drinks",
			"catalog/food-drinks/cold-drinks"
		),$paths);

		$paths = array_map(function($node){ return $node->getPath(); },$nodes[1]->getChildNodes());
		$this->assertEquals(array(
			"catalog/shoes/kids",
			"catalog/shoes/men"
		),$paths);

		// testing aliases

		$root = $this->categories["kids"];

		$tree = CategoryTree::GetInstance($root);

		$nodes = $tree->getChildNodes();
		$this->assertEquals(1,sizeof($nodes));

		$paths = array_map(function($node){ return $node->getPath(); },$nodes[0]->getChildNodes());
		$this->assertEquals(array(
			"kids/shoes/girls",
			"kids/shoes/boys"
		),$paths);
	}
}
