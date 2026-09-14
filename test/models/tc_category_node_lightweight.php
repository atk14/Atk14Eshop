<?php
/**
 * Tests for CategoryLightweightProxy and CategoryNodeLightweight.
 *
 * @fixture categories
 * @fixture tags
 * @fixture category_tags
 */
class TcCategoryNodeLightweight extends TcBase {

	/**
	 * PostgreSQL vrací boolean sloupce jako řetězce 't'/'f'.
	 * Ověřuje, že proxy je správně normalizuje.
	 */
	function test_bool_normalization() {
		$filter_proxy = new CategoryLightweightProxy([
			'id' => 1, 'pointing_to_category_id' => null,
			'name_cs' => 'A', 'name_en' => 'A',
			'is_filter' => 't', 'visible' => 'f',
			'has_vehicle_tag' => false,
		]);
		$this->assertTrue($filter_proxy->isFilter());
		$this->assertFalse((bool)$filter_proxy->g('visible'));

		$normal_proxy = new CategoryLightweightProxy([
			'id' => 2, 'pointing_to_category_id' => null,
			'name_cs' => 'B', 'name_en' => 'B',
			'is_filter' => 'f', 'visible' => 't',
			'has_vehicle_tag' => false,
		]);
		$this->assertFalse($normal_proxy->isFilter());
		$this->assertTrue((bool)$normal_proxy->g('visible'));
	}

	function test_proxy_isPointingToCategory() {
		$alias = new CategoryLightweightProxy([
			'id' => 1, 'is_filter' => 'f', 'visible' => 't',
			'pointing_to_category_id' => 42,
			'name_cs' => 'X', 'name_en' => 'X', 'has_vehicle_tag' => false,
		]);
		$this->assertTrue($alias->isPointingToCategory());

		$normal = new CategoryLightweightProxy([
			'id' => 2, 'is_filter' => 'f', 'visible' => 't',
			'pointing_to_category_id' => null,
			'name_cs' => 'Y', 'name_en' => 'Y', 'has_vehicle_tag' => false,
		]);
		$this->assertFalse($normal->isPointingToCategory());
	}

	function test_proxy_getName() {
		$proxy = new CategoryLightweightProxy([
			'id' => 1, 'is_filter' => 'f', 'visible' => 't',
			'pointing_to_category_id' => null,
			'name_cs' => 'Boty', 'name_en' => 'Shoes',
			'has_vehicle_tag' => false,
		]);
		$this->assertEquals('Boty',  $proxy->getName('cs'));
		$this->assertEquals('Shoes', $proxy->getName('en'));
	}

	function test_proxy_containsTag() {
		$tag = Tag::GetInstanceByCode("sale");

		$with = new CategoryLightweightProxy([
			'id' => 1, 'is_filter' => 'f', 'visible' => 't',
			'pointing_to_category_id' => null,
			'name_cs' => 'X', 'name_en' => 'X', 'has_vehicle_tag' => true,
		]);
		$this->assertTrue($with->containsTag($tag));

		$without = new CategoryLightweightProxy([
			'id' => 2, 'is_filter' => 'f', 'visible' => 't',
			'pointing_to_category_id' => null,
			'name_cs' => 'Y', 'name_en' => 'Y', 'has_vehicle_tag' => false,
		]);
		$this->assertFalse($without->containsTag($tag));
	}

	function test_node_tree_structure() {
		$nodes = [
			10 => ['id' => 10, 'is_filter' => 'f', 'visible' => 't', 'pointing_to_category_id' => null, 'name_cs' => 'Kořen',  'name_en' => 'Root',       'has_vehicle_tag' => false],
			11 => ['id' => 11, 'is_filter' => 't', 'visible' => 'f', 'pointing_to_category_id' => null, 'name_cs' => 'Filtr',  'name_en' => 'Filter',     'has_vehicle_tag' => false],
			12 => ['id' => 12, 'is_filter' => 'f', 'visible' => 't', 'pointing_to_category_id' => 99,  'name_cs' => 'Alias',  'name_en' => 'Alias',      'has_vehicle_tag' => true],
			13 => ['id' => 13, 'is_filter' => 'f', 'visible' => 't', 'pointing_to_category_id' => null, 'name_cs' => 'Vnouče', 'name_en' => 'Grandchild', 'has_vehicle_tag' => false],
		];
		$children = [
			'10' => [11, 12],
			'11' => [13],
		];

		$root = new CategoryNodeLightweight(10, $nodes, $children);

		// root má 2 přímé potomky
		$this->assertTrue($root->hasChildCategories());
		$this->assertEquals(2, count($root));

		$top = iterator_to_array($root->getIterator());
		$this->assertEquals(2, count($top));

		// první potomek: filtr, neviditelný, má vnouče
		$filter_node = $top[0];
		$this->assertTrue($filter_node->getCategory()->isFilter());
		$this->assertFalse((bool)$filter_node->getCategory()->g('visible'));
		$this->assertTrue($filter_node->hasChildCategories());
		$this->assertEquals(1, count($filter_node));

		// druhý potomek: alias, má štítek vehicle, nemá děti
		$alias_node = $top[1];
		$this->assertTrue($alias_node->getCategory()->isPointingToCategory());
		$this->assertTrue($alias_node->getCategory()->containsTag(null));
		$this->assertFalse($alias_node->hasChildCategories());
		$this->assertEquals(0, count($alias_node));

		// vnouče
		$grandchildren = iterator_to_array($filter_node->getIterator());
		$this->assertEquals(1, count($grandchildren));
		$this->assertEquals('Grandchild', $grandchildren[0]->getCategory()->getName('en'));
	}

	/**
	 * Klíčový integrační test: porovná hodnoty vrácené lightweight proxy
	 * s hodnotami ORM Category objektů pro každou kategorii ve stromě catalog.
	 */
	function test_proxy_matches_orm_for_catalog() {
		$root = $this->categories['catalog'];
		$dbmole = Category::GetDbMole();

		$rows = $dbmole->selectRows(
			"WITH RECURSIVE subtree(id, parent_category_id, rank) AS (
				SELECT id, parent_category_id, rank FROM categories WHERE id = :root_id
			UNION
				SELECT c.id, c.parent_category_id, c.rank
				FROM categories c JOIN subtree s ON c.parent_category_id = s.id
			)
			SELECT
				c.id, c.parent_category_id,
				c.visible, c.is_filter, c.pointing_to_category_id,
				MAX(CASE WHEN t.key = 'name' AND t.lang = 'cs' THEN t.body END) AS name_cs,
				MAX(CASE WHEN t.key = 'name' AND t.lang = 'en' THEN t.body END) AS name_en
			FROM categories c
			JOIN subtree s ON c.id = s.id
			LEFT JOIN translations t
				ON t.table_name = 'categories' AND t.record_id = c.id AND t.key = 'name'
			GROUP BY c.id, c.parent_category_id, c.visible, c.is_filter, c.pointing_to_category_id, c.rank
			ORDER BY c.parent_category_id, c.rank, c.id",
			[':root_id' => $root->getId()]
		);

		$this->assertTrue(count($rows) > 0, "Dotaz musí vrátit alespoň jeden řádek");

		foreach ($rows as $row) {
			$row['has_vehicle_tag'] = false; // vehicle tag není v fixtures
			$proxy    = new CategoryLightweightProxy($row);
			$category = Category::FindById($row['id']);

			$this->assertEquals(
				$category->getId(),
				$proxy->getId(),
				"id nesedí pro kategorii {$row['id']}"
			);
			$this->assertEquals(
				$category->isFilter(),
				$proxy->isFilter(),
				"isFilter() nesedí pro kategorii {$row['id']}"
			);
			$this->assertEquals(
				$category->isPointingToCategory(),
				$proxy->isPointingToCategory(),
				"isPointingToCategory() nesedí pro kategorii {$row['id']}"
			);
			$this->assertEquals(
				(bool)$category->g('visible'),
				(bool)$proxy->g('visible'),
				"visible nesedí pro kategorii {$row['id']}"
			);
			$this->assertEquals(
				$category->getName('en'),
				$proxy->getName('en'),
				"getName('en') nesedí pro kategorii {$row['id']}"
			);
			$this->assertEquals(
				$category->getName('cs'),
				$proxy->getName('cs'),
				"getName('cs') nesedí pro kategorii {$row['id']}"
			);
		}
	}
}
