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

		foreach([0,1] as $dealias) {
			$tree = CategoryTree::GetInstance($root, ['dealias' => $dealias]);

			$nodes = $tree->getChildNodes();
			$this->assertEquals(1,sizeof($nodes));

			$paths = array_map(function($node){ return $node->getPath(); },$nodes[0]->getChildNodes());
			$this->assertEquals(array(
				"kids/shoes/girls",
				"kids/shoes/boys",
			),$paths);
		}

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
				 'coffeine-drinks' => 2,
				 'hot-drinks' => 2 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(4, $tree->getChildCategoriesCount());
		$this->assertEquals(3, $tree->getCardsCount());

		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => 'any' ]);
		foreach($tree as $t) {
			$this->assertEquals(
				['cold-drinks' => 1,
				 'coffeine-drinks' => 2,
				 'hot-drinks' => 2 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(3, $tree->getCardsCount());

		$filter = new FilterForCards(User::GetAnonymousUser(), ['category' => $this->categories['food_drinks']]);
		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => true, 'cards_filter' => $filter]);
		foreach($tree as $t) {
			$this->assertEquals(
				['cold-drinks' => 1,
				 'coffeine-drinks' => 2,
				 'hot-drinks' => 2 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(3, $tree->getCardsCount());

		//'has_cards' => 'true': test for non-boolean value
		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => 'true', 'cards_filter' => $filter]);
		foreach($tree as $t) {
			$this->assertEquals(
				['cold-drinks' => 1,
				 'coffeine-drinks' => 2,
				 'hot-drinks' => 2 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(3, $tree->getCardsCount());

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

		$cat = Category::CreateNewRecord(['parent_category_id' => $this->categories['other_drinks'], 'pointing_to_category_id' => $this->categories['mens_shoes'], 'name_en' => 
		'eatable_shoes']);
		$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => true, 'no_aliases' => true]);
		foreach($tree as $t) {
			$this->assertEquals(
				[ 'coffeine-drinks' => 2,
				  'cold-drinks' => 1,
				 'hot-drinks' => 2 ][$t->getSlug()],
				 $t->getCardsCount());
		}
		$this->assertEquals(3, $tree->getChildCategoriesCount());
		$this->assertEquals(3, $tree->getCardsCount());

		foreach([ $this->categories['mens_shoes'],  $this->categories['shoes'] ] as $c) {
			foreach([ true, false ] as $dealias) {
				$this->assertNotNull($c);
				$cat->s('pointing_to_category_id', $c);
				$tree = CategoryTree::GetInstance($this->categories['food_drinks'],['return_cards_count' => true, 'has_cards' => true, 'dealias' => $dealias]);
				$this->assertEquals(4, $tree->getChildCategoriesCount());
				$this->assertEquals(4, $tree->getCardsCount());
				$tree->fetch();

				foreach($tree as $t) {
				$this->assertEquals(
					[ 'coffeine-drinks' => 2,
						'other-drinks' => 1,
						'cold-drinks' => 1,
					 'hot-drinks' => 2 ][$t->getSlug()],
					 $t->getCardsCount());
				}
			}
		}

		$this->categories['kids_shoes__boys']->addCard($this->cards['shoe']);
		$this->callForData(
			['has_cards' => [0,1],
			 'dealiased_input' => [0,1],
			 'dealias' => [0,1]
			],
			function($opts) {
				if(!$opts['dealiased_input']) {
					$this->callForData(
						['level' => [null, 3],
						 'return_cards_count' => [0,1]
						],
						function($opts) {
							$hcds= $opts['return_cards_count'];
							$tree = CategoryTree::GetInstance([$this->categories['other_drinks']], ['level' => 3, 'self' => true ]+$opts);
							$this->assertEquals(1,$tree->getChildCategoriesCount());
							$this->assertNotNull($node=$tree->getNodeByPath('other-drinks'));
							$hcds && $this->assertEquals(1, $node->getCardsCount());
							$this->assertNotNull($node=$tree->getNodeByPath('other-drinks/eatable-shoes'));
							$hcds && $this->assertEquals(1, $node->getCardsCount());
							$this->assertTrue($node->hasChildCategories());
							$this->assertTrue((bool) $node->getChildNodes());
					}, $opts);
				}

				$tree = CategoryTree::GetInstance([$this->categories['catalog']],['level' => 2, 'self' => true]+$opts);
				$this->assertNull($node=$tree->getNodeByPath('catalog/food-drinks/other-drinks-not-exists'));
				$this->assertNull($node=$tree->getNodeByPath('catalog-not-exists'));
				$this->assertNotNull($node=$tree->getNodeByPath('catalog/food-drinks/other-drinks'));
				$this->assertEquals($node->getSlug(), 'other-drinks');
				$this->assertFalse($node->hasChilds());

				$tree = CategoryTree::GetInstance([$this->categories['catalog']],['level' => 2, 'self' => false]+$opts);
				$this->assertNull($node=$tree->getNodeByPath('food-drinks/other-drinks-not-exists'));
				$this->assertNull($node=$tree->getNodeByPath('catalog-not-exists'));
				$this->assertNotNull($node=$tree->getNodeByPath('food-drinks/other-drinks'));
				$this->assertEquals($node->getSlug(), 'other-drinks');
				$this->assertFalse($node->hasChilds());

				$this->callForData(
					['self' => [ false, true]], function($opts) {
						$tree = CategoryTree::GetInstance($this->categories['catalog'],['level' => 2]+$opts);
						$this->assertNull($node=$tree->getNodeByPath('food-drinks/other-drinks-not-exists'));
						$this->assertNull($node=$tree->getNodeByPath('catalog-not-exists'));
						$this->assertNotNull($node=$tree->getNodeByPath('food-drinks/other-drinks'));
						$this->assertEquals($node->getSlug(), 'other-drinks');
						$this->assertFalse($node->hasChilds());

						$tree = CategoryTree::GetInstance($this->categories['catalog'],['level' => 2, 'min_level' => 2] + $opts);
						$this->assertNotNull($node=$tree->getNodeByPath('other-drinks'));
						$this->assertFalse($node->hasChilds());
				}, $opts);

				$tree = CategoryTree::GetInstance($this->categories['catalog'],['level' => 4, 'self' => false] + $opts);
				$this->assertNotNull($node=$tree->getNodeByPath('food-drinks/other-drinks/eatable-shoes/kids'));
				$this->assertFalse($node->hasChilds());
			}
		);
		$this->callForData(
			['direct_children_only' => [0,1],
			 'has_cards' => [0,1]],
			function($opts) {
			  $opts += ['dealiased_input' => false, 'self' => false];
				#test for aliased categories to be properly readed (and dealiased) even if self=false
				$tree=CategoryTree::GetInstance($this->categories['kids__kids_shoes'], $opts);
				$this->assertTrue($tree->hasChildCategories());
			}
		);

		#test, that conditions and bind_ar works
		$tree = CategoryTree::GetInstance($this->categories['catalog'],['level' => 4, 'self' => false,
			'bind_ar' => [':idid' => $this->categories['food_drinks']],
			'conditions' => 'c.id = :idid',
			'dealiased_input' => true
		]);
		$tree->fetch();
		$this->assertEquals(1, $tree->getChildCategoriesCount());

		#test, that the conditions are not applied on self when resolving potential alias (pointing_to_category_id)
		$tree = CategoryTree::GetInstance($this->categories['catalog'],['level' => 4, 'self' => false,
			'bind_ar' => [':idid' => $this->categories['food_drinks']],
			'conditions' => 'c.id = :idid',
			'dealiased_input' => false
		]);
		$this->assertEquals(1, $tree->getChildCategoriesCount());
	}
}
