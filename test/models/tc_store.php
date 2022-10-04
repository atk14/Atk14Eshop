<?php
/**
 *
 * @fixture stores
 * @fixture delivery_methods
 */
class TcStore extends TcBase {

	function test(){
		
		$store = $this->stores["test"];

		$this->assertEquals("Street\n111 00 City",$store->getAddress());
		$this->assertContains("Street\n111 00 City\nCzech",$store->getAddress(array("with_country" => true))); // "Czechia" or "Czech Republic"

		$this->assertEquals("Street, 111 00 City",$store->getAddress(["connector" => ", "]));
		$this->assertEquals("Testing store, Street, 111 00 City",$store->getAddress(["connector" => ", ", "with_name" => true]));

		$store->s("address_en","\n\nTESTING STORE as Street in City\n\n");
		$this->assertEquals("TESTING STORE as Street in City",$store->getAddress());
	}

	function test_isDeletable(){
		$store = $this->stores["test"];
		$eshop = Store::GetInstanceByCode("eshop");
		$just_store = Store::CreateNewRecord(array());

		$this->assertFalse($store->isDeletable()); // there is a delivery method with personal pickup on this store
		$this->assertFalse($eshop->isDeletable()); // code=eshop
		$this->assertTrue($just_store->isDeletable());
	}
}
