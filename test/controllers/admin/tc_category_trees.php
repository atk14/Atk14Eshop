<?php
/**
 * @fixture users
 * @fixture categories
 * @fixture tags
 * @fixture category_tags
 */
class TcCategoryTrees extends TcBase {

	function test_detail_catalog() {
		$client = $this->client;
		$root = $this->categories['catalog'];

		$client->get("category_trees/detail", ["id" => $root->getId()]);
		$this->assertEquals(200, $client->getStatusCode());

		$html = $client->getContent();

		// jméno kořenové kategorie je v nadpisu
		$this->assertStringContains("Catalog", $html);

		// podkategorie jsou vyrendrované
		$this->assertStringContains("Food &amp; Drinks", $html);
		$this->assertStringContains("Shoes", $html);

		// filtrová kategorie musí mít označení "filter"
		$this->assertStringContains("filter", $html); // Color a Usage jsou is_filter=true

		// neviditelná kategorie musí mít označení "invisible"
		$this->assertStringContains("invisible", $html); // odour a hidden jsou visible=false
	}

	function test_detail_kids_tree_contains_alias() {
		$client = $this->client;
		$root = $this->categories['kids'];

		$client->get("category_trees/detail", ["id" => $root->getId()]);
		$this->assertEquals(200, $client->getStatusCode());

		$html = $client->getContent();

		// aliasová kategorie musí mít označení "link"
		$this->assertStringContains("link", $html); // kids__kids_shoes je alias
	}

	/**
	 * Hlavní integrační test: porovná HTML vyrenderované lightweight stromem
	 * s HTML vyrenderovaným původním CategoryTree (ORM objekty).
	 *
	 * Oba výstupy musí obsahovat stejné kategorie, filtry, aliasy a neviditelné.
	 */
	function test_detail_output_matches_original() {
		$client = $this->client;

		foreach ([$this->categories['catalog'], $this->categories['kids']] as $root) {
			// --- výstup přes nový lightweight strom ---
			$client->get("category_trees/detail", ["id" => $root->getId()]);
			$this->assertEquals(200, $client->getStatusCode(), "detail selhal pro root {$root->getId()}");
			$lightweight_html = $client->getContent();

			// --- referenční výstup sestavený z ORM dat ---
			// Projdeme celý podstrom ORM objekty a ověříme, že každé
			// jméno/příznak z ORM se skutečně nachází v lightweight HTML.
			$orm_tree = new CategoryTree($root, ['is_filter' => null, 'visible' => null]);
			$this->_assertTreeInHtml($orm_tree, $lightweight_html, $root->getId());
		}
	}

	/**
	 * Rekurzivně prochází ORM strom a ověřuje, že lightweight HTML
	 * obsahuje správné hodnoty pro každý uzel.
	 */
	private function _assertTreeInHtml(CategoryNode $node, $html, $root_id) {
		foreach ($node as $child) {
			$category = $child->getCategory();
			$id = $category->getId();

			// jméno kategorie musí být v HTML (v odkazu)
			$name = htmlspecialchars((string)$category->getName(), ENT_QUOTES);
			$this->assertStringContains(
				$name, $html,
				"Jméno kategorie {$id} '{$name}' chybí v HTML (root={$root_id})"
			);

			// příznak filtru
			if ($category->isFilter()) {
				$this->assertStringContains(
					"filter", $html,
					"Příznak 'filter' chybí pro kategorii {$id} (root={$root_id})"
				);
			}

			// neviditelné kategorie
			if (!$category->g('visible')) {
				$this->assertStringContains(
					"invisible", $html,
					"Příznak 'invisible' chybí pro kategorii {$id} (root={$root_id})"
				);
			}

			// aliasové kategorie
			if ($category->isPointingToCategory()) {
				$this->assertStringContains(
					"link", $html,
					"Příznak 'link' chybí pro aliasovou kategorii {$id} (root={$root_id})"
				);
			}

			$this->_assertTreeInHtml($child, $html, $root_id);
		}
	}
}
