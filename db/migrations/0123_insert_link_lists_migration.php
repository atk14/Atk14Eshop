<?php
/**
 *
 */
class InsertLinkListsMigration extends ApplicationMigration {

	function up() {
		global $ATK14_GLOBAL;

		$lang = $ATK14_GLOBAL->getDefaultLang();

		// ### Main links
		$ll_main = LinkList::CreateNewRecord([
			"code" => "main",
			"name" => "Main links",
		]);
		$items_main = [
			[
				"label_en" => "Home",
				"label_cs" => "Úvod",
				"url" => "/",
			],
			[
				"label_en" => "Articles",
				"label_cs" => "Články",
				"url" => "/en/articles/",
			],
			[
				"label_en" => "Eshop",
				"label_cs" => "Obchod",
				"url" => $this->_link_to_category("catalog"),
			],
			[
				"label_en" => "Contact",
				"label_cs" => "Kontakt",
				"url" => $this->_link_to_page("contact"),
			]
		];

		// ### Footer #1
		$ll_footer_1 = LinkList::CreateNewRecord([
			"name" => "Footer #1",
			"code" => "footer_1",
			"label_en" => "Links",
			"label_cs" => "Odkazy"
		]);
		$items_footer_1 = [
			[
				"label_en" => "Goods",
				"label_cs" => "Zboží",
				"url" => $this->_link_to_category("catalog"),
			],
			[
				"label_en" => "Brands",
				"label_cs" => "Značky",
				"url" => $this->_link_to("brands/index"),
			],
			[
				"label_en" => "Collections",
				"label_cs" => "Kolekce",
				"url" => $this->_link_to("collections/index"),
			],
			[
				"label_en" => "Stores",
				"label_cs" => "Prodejny",
				"url" => $this->_link_to("stores/index"),
			],
			[
				"label_en" => "News",
				"label_cs" => "Aktuality",
				"url" => $this->_link_to("articles/index"),
			],
		];


		// ### Footer #2
		$ll_footer_2 = LinkList::CreateNewRecord([
			"name" => "Footer #2",
			"code" => "footer_2",
			"label_en" => "Information",
			"label_cs" => "Informace",
		]);
		$items_footer_2 = [
			[
				"label_en" => "Goods",
				"label_cs" => "Zboží",
				"url" => $this->_link_to_category("catalog"),
			],
			[
				"label_en" => "Stores",
				"label_cs" => "Prodejny",
				"url" => $this->_link_to("stores/index"),
			],
			[
				"label_en" => "News",
				"label_cs" => "Aktuality",
				"url" => $this->_link_to("articles/index"),
			],
			[
				"label_en" => "Contact data",
				"label_cs" => "Kontakty",
				"url" => $this->_link_to_page("contact"),
			],
		];

		$this->_import_items($ll_main,$items_main);
		$this->_import_items($ll_footer_1,$items_footer_1);
		$this->_import_items($ll_footer_2,$items_footer_2);
	}

	function _import_items($link_list,$items){
		foreach($items as $item){
			$item["link_list_id"] = $link_list;
			$item += [
				"regions" => '{"CZ": true}',
			];
			LinkListItem::CreateNewRecord($item);
		}
	}

	function _link_to($params){
		return Atk14Url::BuildLink($params);
	}

	function _link_to_page($code){
		Atk14Require::Helper("modifier.link_to_page");
		return smarty_modifier_link_to_page($code);
	}

	function _link_to_category($code){
		Atk14Require::Helper("modifier.link_to_category");
		return smarty_modifier_link_to_category($code);
	}
}
