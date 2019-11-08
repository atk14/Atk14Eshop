<?php
/**
 *
 * @fixture stores
 */
class TcLinkToStore extends TcBase {

	function test(){
		global $ATK14_GLOBAL;

		Atk14Require::Helper("modifier.link_to_store");

		$ATK14_GLOBAL->setValue("lang","en");

		$link = smarty_modifier_link_to_store("test");
		$this->assertEquals("/stores/testing-store/",$link);

		$link = smarty_modifier_link_to_store("test","with_hostname");
		$this->assertEquals("http://".ATK14_HTTP_HOST."/stores/testing-store/",$link);

		$link = smarty_modifier_link_to_store("nonsence");
		$this->assertEquals("/en/main/page_not_found/?store=nonsence",$link);

		$link = smarty_modifier_link_to_store("nonsence","with_hostname");
		$this->assertEquals("http://".ATK14_HTTP_HOST."/en/main/page_not_found/?store=nonsence",$link);

		$ATK14_GLOBAL->setValue("lang","cs");

		$link = smarty_modifier_link_to_store("test");
		$this->assertEquals("/prodejny/testovaci-store/",$link);

		$link = smarty_modifier_link_to_store("test","with_hostname");
		$this->assertEquals("http://".ATK14_HTTP_HOST."/prodejny/testovaci-store/",$link);

		$link = smarty_modifier_link_to_store("nonsence");
		$this->assertEquals("/cs/main/page_not_found/?store=nonsence",$link);

		$link = smarty_modifier_link_to_store("nonsence","with_hostname");
		$this->assertEquals("http://".ATK14_HTTP_HOST."/cs/main/page_not_found/?store=nonsence",$link);
	}
}
