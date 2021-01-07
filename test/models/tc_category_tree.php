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

		$paths = array_map(function($category){ return $category->getPath(); },$nodes[0]->getChildCategories());
		$this->assertEquals(array(
			"catalog/color/red",
			"catalog/color/green",
			"catalog/color/yellow",
			"catalog/color/blue",
		),$paths);

		$paths = array_map(function($category){ return $category->getPath(); },$nodes[1]->getChildCategories());
		$this->assertEquals(array(
			"catalog/usage/outdoor",
			"catalog/usage/indoor",
		),$paths);

		// etc.
	}
}
