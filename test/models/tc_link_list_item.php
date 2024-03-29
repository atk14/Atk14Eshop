<?php
/**
 *
 * @fixture pages
 * @fixture brands
 * @fixture categories
 *
 * this needs to be the last fixture
 * @fixture link_list_items
 */
class TcLinkListItem extends TcBase {

	function test(){
		$li_testing_page = $this->link_list_items["main_menu__testing_page"];
		$target = $li_testing_page->getTargetObject();
		$this->assertEquals(true,is_a($target,"Page"));
		$this->assertEquals("testing_page",$target->getCode());

		$li_homepage = $this->link_list_items["main_menu__homepage"];
		$target = $li_homepage->getTargetObject();
		$this->assertEquals(true,is_a($target,"Page"));
		$this->assertEquals("homepage",$target->getCode());

		$li_external = $this->link_list_items["main_menu__external"];
		$this->assertEquals(null,$li_external->getTargetObject());

		$li_catalog = $this->link_list_items["main_menu__catalog"];
		$target = $li_catalog->getTargetObject();
		$this->assertEquals(true,is_a($target,"Category"));
		$this->assertEquals("catalog",$target->getCode());
		
	}

	function test_getSubmenu(){
		$lli = $this->link_list_items["main_menu__testing_page"];
		$submenu = $lli->getSubmenu();
		$this->assertNotNull($submenu);
		$items = $submenu->getItems();
		$this->assertEquals(1,sizeof($items)); // there is one subpage
		$this->assertEquals(Atk14Url::BuildLink(["namespace" => "", "action" => "pages/detail", "id" => $this->pages["testing_subpage"]]),$items[0]->getUrl());

		$lli = $this->link_list_items["main_menu__external"];
		$this->assertEquals(null,$lli->getSubmenu());

		$lli = $this->link_list_items["main_menu__brands"];
		$submenu = $lli->getSubmenu();
		$this->assertNotNull($submenu);
		$items = $submenu->getItems();
		$this->assertEquals(5,sizeof($items)); // there are two brands
		$this->assertEquals(Atk14Url::BuildLink(["namespace" => "", "action" => "brands/detail", "id" => $this->brands["bob_and_son"]]),$items[0]->getUrl());
		$this->assertEquals(Atk14Url::BuildLink(["namespace" => "", "action" => "brands/detail", "id" => $this->brands["heavenly_good_shoes"]]),$items[1]->getUrl());
		$this->assertEquals(Atk14Url::BuildLink(["namespace" => "", "action" => "brands/detail", "id" => $this->brands["microsoft"]]),$items[2]->getUrl());
		$this->assertEquals(Atk14Url::BuildLink(["namespace" => "", "action" => "brands/detail", "id" => $this->brands["oracle"]]),$items[3]->getUrl());
		$this->assertEquals(Atk14Url::BuildLink(["namespace" => "", "action" => "brands/detail", "id" => $this->brands["suse"]]),$items[4]->getUrl());

		// submenu linked by the same code (main_menu_code)
		$lli = $this->link_list_items["test_list__main_menu"];
		$submenu = $lli->getSubmenu();
		$items = $submenu->getItems();
		$this->assertEquals(5,sizeof($items));
		$this->assertEquals("Home",$items[0]->getTitle());
		$this->assertEquals("/",$items[0]->getUrl());
		$this->assertEquals("Testing page",$items[1]->getTitle());
		$this->assertEquals("/testing-page/",$items[1]->getUrl());
		$this->assertEquals("ATK14 Framework",$items[2]->getTitle());
		$this->assertEquals("https://www.atk14.net/",$items[2]->getUrl());
		$this->assertEquals("atk14_framework",$items[2]->getMeta("code"));
		$this->assertEquals("http://www.atk14.net/public/images/atk14.png",$items[2]->getMeta("image_url"));


		$lli->s("code","different_code");
		$this->assertEquals(null,$lli->getSubmenu());
	}

	function test_changing_url_according_to_language(){
		// local URI

		$item = $this->link_list_items["main_menu__testing_page"];
		$this->assertEquals("/testing-page/",$item->getUrl());

		$lang = "cs";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("/testovaci-stranka/",$item->getUrl());

		$lang = "en";
		Atk14Locale::Initialize($lang);
		
		$item->s("url","/testing-page/#anchor");

		$this->assertEquals("/testing-page/#anchor",$item->getUrl());

		$lang = "cs";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("/testovaci-stranka/#anchor",$item->getUrl());
		$this->assertEquals("/testovaci-stranka/#test",$item->getUrl(["anchor" => "test"]));
		$this->assertEquals("/testovaci-stranka/",$item->getUrl(["anchor" => ""]));

		// complete local URL

		$item = $this->link_list_items["test_list__testing_subpage"];
		$http_host = ATK14_HTTP_HOST;

		$this->assertEquals("http://".$http_host."/testing-page/testing-subpage/",$item->g("url"));

		$lang = "en";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("http://$http_host/testing-page/testing-subpage/",$item->getUrl());
		$this->assertEquals("/testing-page/testing-subpage/",$item->getUrl(["with_hostname" => false]));

		$lang = "cs";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("http://$http_host/testovaci-stranka/testovaci-podstranka/",$item->getUrl());
		$this->assertEquals("/testovaci-stranka/testovaci-podstranka/",$item->getUrl(["with_hostname" => false]));
		
		// external URL

		$item = $this->link_list_items["main_menu__external"];

		$lang = "en";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("https://www.atk14.net/",$item->getUrl());

		$lang = "cs";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("https://www.atk14.net/",$item->getUrl());
	}

	function test_specific_url_for_language(){
		$item = $this->link_list_items["main_menu__testing_page"];

		$item->s("url_localized_en","/testing-page/?english=1");

		$lang = "en";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("/testing-page/?english=1",$item->getUrl());
		$this->assertEquals("/testing-page/?english=1",$item->getUrl("en"));
		$this->assertEquals("/testovaci-stranka/",$item->getUrl("cs"));

		$lang = "cs";
		Atk14Locale::Initialize($lang);
		$this->assertEquals("/testovaci-stranka/",$item->getUrl());
		$this->assertEquals("/testing-page/?english=1",$item->getUrl("en"));
		$this->assertEquals("/testovaci-stranka/",$item->getUrl("cs"));
	}
}
