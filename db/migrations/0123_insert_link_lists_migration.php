<?php
/**
 *
 */
class InsertLinkListsMigration extends ApplicationMigration {

	function up() {
		global $ATK14_GLOBAL;

		$lang = $ATK14_GLOBAL->getDefaultLang();

		$ll_header = LinkList::CreateNewRecord([
			"code" => "header",
			"name" => "Hader",
		]);

		$items_header = [
			[
				"label_en" => "Home",
				"label_cs" => "Úvod"
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
				"url" => $this->_link_to_page("contacts"),
			]
		];

		$ll_footer_1 = LinkList::CreateNewRecord([
			"name" => "Footer #1",
			"code" => "footer_1",
		]);
		$ll_footer_2 = LinkList::CreateNewRecord([
			"name" => "Footer #2",
			"code" => "footer_2",
			"label_cs" => "",
		]);

		$items_top = [
			[
				"label_cs" => "Zboží",
				"url" => $this->_link_to_page("goods"),
			],
			[
				"label_en" => "Stores"
				"label_cs" => "Prodejny",
				"url" => "/$lang/stores/",
			],
			[
				"label_en" => "News",
				"label_cs" => "Aktuality",
				"url" => "/$lang/articles/"
			],
			[
				"label_cs" => "Zaměstnání",
				"url" => "/$lang/job_offers/"
			],
			[
				"label_cs" => "Kontakty",
				"url" => "/$lang/contacts/"
			],
		];

		$items_foot_1 = [
			[
				"label_cs" => "Látky",
				"url" => $this->_link_to_page("fabrics"),
			],
			[
				"label_cs" => "Značky",
				"url" => $this->_link_to_page("brands"),
			],
			[
				"label_cs" => "Galanterie",
				"url" => $this->_link_to_page("notions"),
			],
			[
				"label_cs" => "Pomůcky na patchwork",
				"url" => $this->_link_to_page("patchwork"),
			],
		];

		$items_foot_2 = [
			[
				"label_cs" => "Prodejny",
				"url" => "/cs/stores/",
			],
			[
				"label_cs" => "Aktuality",
				"url" => "/cs/articles/"
			],
			[
				"label_cs" => "Velkoobchod",
				"url" => "/cs/wholesaling/"
			],
			[
				"label_cs" => "O firmě",
				"url" => $this->_link_to_page("about_us"),
			],
			[
				"label_cs" => "Zaměstnání",
				"url" => "/cs/job_offers/",
			],
			[
				"label_cs" => "Kontakty",
				"url" => "/cs/contacts/",
			],
			[
				"label_cs" => "Kupóny",
				"url" => "/cs/coupons/",
			],
		];

		$this->_import_items($ll_top,$items_top);
		$this->_import_items($ll_footer_1,$items_foot_1);
		$this->_import_items($ll_footer_2,$items_foot_2);
	}

	function _import_items($link_list,$items){
		foreach($items as $item){
			$item["link_list_id"] = $link_list;
			LinkListItem::CreateNewRecord($item);
		}
	}

	function _link_to_page($code){
		return Atk14Url::BuildLink(["action" => "pages/detail", "id" => Page::FindByCode($code)]);
	}
}
