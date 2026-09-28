<?php
class TcSupport extends TcBase {

	function test_GetTitle(){
		$controller = new Atk14Controller();

		$controller->page_title = "Some Title";
		$this->assertEquals("Some Title | ".ATK14_APPLICATION_NAME,\HeadTags\Support\OpenGraph::GetTitle($controller));

		$controller->page_title = ATK14_APPLICATION_NAME;
		$this->assertEquals(ATK14_APPLICATION_NAME,\HeadTags\Support\OpenGraph::GetTitle($controller));
	}
}
