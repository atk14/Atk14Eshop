<?php
/**
 *
 * @fixture stores
 */
class TcDeliveryMethod extends TcBase {

	function test_getEmailDescription(){
		$dm = DeliveryMethod::CreateNewRecord([
			"personal_pickup" => true,
			"personal_pickup_on_store_id" => $this->stores["test"],
			"description_en" => "Description",
			"email_description_en" => "",
		]);
		$this->assertEquals("Testing store, Street, 111 00 City",$dm->getEmailDescription());

		$dm->s("personal_pickup",false);
		$this->assertEquals(null,$dm->getEmailDescription());

		$dm->s(["personal_pickup" => true, "personal_pickup_on_store_id" => null]);
		$this->assertEquals(null,$dm->getEmailDescription());

		$dm->s("personal_pickup_on_store_id",$this->stores["test"]);
		$this->assertEquals("Testing store, Street, 111 00 City",$dm->getEmailDescription());

		$dm->s("email_description_en","Email description");
		$this->assertEquals("Email description",$dm->getEmailDescription());
	}
}
