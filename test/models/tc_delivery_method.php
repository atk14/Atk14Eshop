<?php
/**
 *
 * @fixture stores
 */
class TcDeliveryMethod extends TcBase {

	function test_getEmailDescription(){
		$store = Cache::Get("Store",$this->stores["test"]);

		$dm = DeliveryMethod::CreateNewRecord([
			"personal_pickup" => true,
			"personal_pickup_on_store_id" => $store,
			"description_en" => "Description",
			"email_description_en" => "",
		]);
		$this->assertEquals("Testing store, Street, 111 00 City, opening hours: Monday: closed. Tuesday-Sunday: 10 AM - 6 PM.",$dm->getEmailDescription());

		$store->s("opening_hours_en","");
		$this->assertEquals("Testing store, Street, 111 00 City",$dm->getEmailDescription());

		$dm->s("personal_pickup",false);
		$this->assertEquals(null,$dm->getEmailDescription());

		$dm->s(["personal_pickup" => true, "personal_pickup_on_store_id" => null]);
		$this->assertEquals(null,$dm->getEmailDescription());

		$dm->s("personal_pickup_on_store_id",$store);
		$this->assertEquals("Testing store, Street, 111 00 City",$dm->getEmailDescription());

		$dm->s("email_description_en","Email description");
		$this->assertEquals("Email description",$dm->getEmailDescription());
	}
}
