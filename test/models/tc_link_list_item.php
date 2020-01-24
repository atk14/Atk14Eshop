<?php
/**
 *
 * @fixture categories
 * @fixture pages
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

		$li_catalog = $this->link_list_items["main_menu__catalog"];
		$target = $li_catalog->getTargetObject();
		$this->assertEquals(true,is_a($target,"Category"));
		$this->assertEquals("catalog",$target->getCode());
		
		$li_external = $this->link_list_items["main_menu__external"];
		$this->assertEquals(null,$li_external->getTargetObject());
	}
}
