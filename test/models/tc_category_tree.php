<?php
/**
 *
 * @fixture categories
 * @fixture cards
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
			"catalog/food-drinks/cold-drinks",
			"catalog/food-drinks/other-drinks",
			"catalog/food-drinks/coffeine-drinks"
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
			"catalog/food-drinks/cold-drinks",
			"catalog/food-drinks/other-drinks",
			"catalog/food-drinks/coffeine-drinks"
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

		$tree = CategoryTree::GetInstance(null, ["order_by" => "(SELECT code FROM categories WHERE id = tree.id)"]);
		$out=[];
		foreach($tree as $t) {
			$out[] = $t->getPath();
		}
		$this->assertEquals(['catalog', 'kids'], $out);

		$tree = CategoryTree::GetInstance($this->categories['kids'], [
			'no_aliases' => true,
			'return_me' => false
		]);
		$this->assertFalse($tree->hasChilds());
		$tree = CategoryTree::GetInstance($this->categories['kids'], [
			'return_me' => true
		]);
		$this->assertEquals('kids', $tree->getPath());
		$this->assertEquals('kids/shoes', $tree->getChildNodes()[0]->getPath());
		$this->assertEquals('kids/shoes/girls', $tree->getChildNodes()[0]->getChildNodes()[0]->getPath());

		$this->assertEquals(4, CategoryTree::GetInstance($this->categories['food_drinks'])->getChildCategoriesCount());
		$this->assertEquals(3, CategoryTree::GetInstance($this->categories['food_drinks'], ['has_cards' => true])->getChildCategoriesCount());

		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true]);
		foreach($tree as $t) {
			$this->assertEquals(
				['other-drinks' => 0,
				 'cold-drinks' => 1,
				 'coffeine-drinks' => 1,
				 'hot-drinks' => 1 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(4, $tree->getChildCategoriesCount());
		$this->assertEquals(2, $tree->getCardsCount());

		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => 'any' ]);
		foreach($tree as $t) {
			$this->assertEquals(
				['cold-drinks' => 1,
				 'coffeine-drinks' => 1,
				 'hot-drinks' => 1 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(2, $tree->getCardsCount());

		$filter = new FilterForCards(User::GetAnonymousUser(), ['category' => $this->categories['food_drinks']]);
		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => true, 'cards_filter' => $filter]);
		foreach($tree as $t) {
			$this->assertEquals(
				['cold-drinks' => 1,
				 'coffeine-drinks' => 1,
				 'hot-drinks' => 1 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(2, $tree->getCardsCount());

		//'has_cards' => 'true': test for non-boolean value
		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => 'true', 'cards_filter' => $filter]);
		foreach($tree as $t) {
			$this->assertEquals(
				['cold-drinks' => 1,
				 'coffeine-drinks' => 1,
				 'hot-drinks' => 1 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(2, $tree->getCardsCount());

		$filter->parse( ['f_f'.$this->categories['color']->getId() => [$this->categories['color_green']->getId() ] ] );
		$this->assertTrue($filter->isFiltered());
		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => 'any', 'cards_filter' => $filter]);
		foreach($tree as $t) {
			$this->assertEquals(
				['cold-drinks' => 0,
				 'coffeine-drinks' => 1,
				 'hot-drinks' => 1 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(1, $tree->getCardsCount());

		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => true, 'cards_filter' => $filter]);
		foreach($tree as $t) {
			$this->assertEquals(
				[ 'coffeine-drinks' => 1,
				 'hot-drinks' => 1 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(2, $tree->getChildCategoriesCount());
		$this->assertEquals(1, $tree->getCardsCount());

		$cat = Category::CreateNewRecord(['parent_category_id' => $this->categories['other_drinks'], 'pointing_to_category_id' => $this->categories['mens_shoes']]);
		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => true, 'no_aliases' => true]);
		foreach($tree as $t) {
			$this->assertEquals(
				[ 'coffeine-drinks' => 1,
				  'cold-drinks' => 1,
				 'hot-drinks' => 1 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(2, $tree->getCardsCount());

		foreach([ $this->categories['mens_shoes'],  $this->categories['shoes'] ] as $c) {
			foreach([ true, false ] as $dealias) {
				$this->assertNotNull($c);
				$cat->s('pointing_to_category_id', $c);
				$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => true, 'dealias' => $dealias]);
				$this->assertEquals(4, $tree->getChildCategoriesCount());
				$this->assertEquals(3, $tree->getCardsCount());
				$tree->fetch();

				foreach($tree as $t) {
				$this->assertEquals(
					[ 'coffeine-drinks' => 1,
						'other-drinks' => 1,
						'cold-drinks' => 1,
					 'hot-drinks' => 1 ][$t->getSlug()],
					 $t->getCardsCount());
				}
			}
		}
	}

}
