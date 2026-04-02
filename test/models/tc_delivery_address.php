<?php
/**
 *
 * @fixture delivery_addresses
 * @fixture orders
 * @fixture users
 * @fixture delivery_methods
 */
class TcDeliveryAddress extends TcBase {

	function test_toExportArray(){
		$da = $this->delivery_addresses["kveta_doma"];
		$ary = $da->toExportArray();

		$this->assertEquals("+420 605 123 456",$ary["phone"]);
		$this->assertEquals([
			"id",
			"firstname",
			"lastname",
			"company",
			"address_street",
			"address_street2",
			"address_city",
			"address_state",
			"address_zip",
			"address_country",
			"address_note",
			"phone",
		],array_keys($ary));
	}

	function test_GetOrCreateRecordByBasket(){
		$basket = $this->_prepareEmptyBasket();
		$basket->s(["delivery_address_street" => "Elm Street 1"]);
		
		$da = DeliveryAddress::GetOrCreateRecordByBasket($basket);
		$this->assertNull($da); // not created for anonymous user

		$basket->s("user_id",$this->users["rambo"]);

		$da2 = DeliveryAddress::GetOrCreateRecordByBasket($basket);
		$this->assertNotNull($da2);
		$this->assertEquals("Elm Street 1",$da2->getAddressStreet());

		$da3 = DeliveryAddress::GetOrCreateRecordByBasket($basket);
		$this->assertNotNull($da3);
		$this->assertEquals($da2->getId(),$da3->getId());

		$basket->s("delivery_address_street","Elm Street 2");

		$da4 = DeliveryAddress::GetOrCreateRecordByBasket($basket);
		$this->assertNotNull($da4);
		$this->assertNotEquals($da2->getId(),$da4->getId());
		$this->assertEquals("Elm Street 2",$da4->getAddressStreet());

		//

		$basket = $this->_prepareEmptyBasket([
			"user_id" => $this->users["rocky"],
			"delivery_method_id" => $this->delivery_methods["personal"],
		]);

		$da = DeliveryAddress::GetOrCreateRecordByBasket($basket);
		$this->assertNull($da); // not created for personal delivery
	}
}
