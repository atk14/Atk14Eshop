<?php
/**
 *
 * @fixture stores
 */
class TcStore extends TcBase {

	function test(){
		
		$store = $this->stores["test"];

		$this->assertEquals("Street\n111 00 City",$store->getAddress());
		$this->assertContains("Street\n111 00 City\nCzech",$store->getAddress(array("with_country" => true))); // "Czechia" or "Czech Republic"
	}
}
