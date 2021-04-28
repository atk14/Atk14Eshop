<?php
/**
 *
 * @fixture stores
 * @fixture delivery_methods
 * @fixture delivery_method_country_specifications
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

	function test_country_specifications(){
		$dpd = $this->delivery_methods["dpd"];

		$this->assertEquals("dpd_test",$dpd->getCode());
		$this->assertEquals(121.0,$dpd->getPriceInclVat());
		$this->assertEquals(100.0,$dpd->getPrice());
		$this->assertEquals(21.0,$dpd->getVatPercent());

		$this->assertEquals("dpd_test_slovakia",$dpd->getCode("SK"));
		$this->assertEquals(200.0,$dpd->getPriceInclVat("SK"));
		$this->assertEquals(190.47619,$dpd->getPrice("SK"));
		$this->assertEquals(5.0,$dpd->getVatPercent("SK"));

		$this->assertEquals("dpd_test",$dpd->getCode("CZ"));
		$this->assertEquals(121.0,$dpd->getPriceInclVat("CZ"));
		$this->assertEquals(100.0,$dpd->getPrice("CZ"));
		$this->assertEquals(21.0,$dpd->getVatPercent("CZ"));

		$by_agreement = $this->delivery_methods["by_agreement"];

		$this->assertTrue(is_null($by_agreement->getPriceInclVat()));
		$this->assertTrue(is_null($by_agreement->getPrice()));
		$this->assertEquals(21,$by_agreement->getVatPercent());

		//

		$this->assertEquals(121.0,$dpd->getLowestPriceInclVat());
		$this->assertEquals(200.0,$dpd->getHighestPriceInclVat());

		$this->assertEquals(121.0,$dpd->getLowestPriceInclVat(["CZ","SK"]));
		$this->assertEquals(200.0,$dpd->getHighestPriceInclVat(["CZ","SK"]));

		$this->assertEquals(121.0,$dpd->getLowestPriceInclVat(["CZ"]));
		$this->assertEquals(121.0,$dpd->getHighestPriceInclVat(["CZ"]));

		$this->assertEquals(200.0,$dpd->getLowestPriceInclVat(["SK"]));
		$this->assertEquals(200.0,$dpd->getHighestPriceInclVat(["SK"]));
	}
}
