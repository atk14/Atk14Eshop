<?php
/**
 *
 * @fixture regions
 * @fixture users
 * @fixture delivery_methods
 * @fixture payment_methods
 * @fixture cards
 * @fixture products
 * @fixture tags
 */
class TcBasket extends TcBase {

	function test_CreateNewRecord4UserAndRegion(){
		$kveta = $this->users["kveta"];
		$czechoslovakia = $this->regions["czechoslovakia"];

		$kveta = Cache::Get("User",$kveta); // make sure to use the cached instance
	
		// A) Kvetina adresa je ze zeme, kam se dorucuje -> adresa bude nastavena v kosiku jako dorucovaci; fakturacni nebude vyplnena
		$this->assertTrue(in_array($kveta->getAddressCountry(),$czechoslovakia->getDeliveryCountries()));
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);
		$this->assertEquals("Ambrozova 9",$basket->g("delivery_address_street"));
		$this->assertEquals(null,$basket->g("address_street"));
		$basket->destroy();

		// B) Kvetina adresa je ted z jine zeme, nez kam se dorucuje -> v kosiku bude nastavena fakt. adresa, ale dorucovaci musi zustat prazdna
		$kveta->s("address_country","AT"); // Austria
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);
		$this->assertEquals(null,$basket->g("delivery_address_street"));
		$this->assertEquals("Ambrozova 9",$basket->g("address_street"));
		$basket->destroy();

		// C) Kveta ted bude mit posledni pouzitou dorucovaci adresu stejnou jako svoji fakturacni -> je to stejny pripad jako pokus (A)
		$kveta->s("address_country","CZ");
		$delivery_address = DeliveryAddress::CreateNewRecord([
			"user_id" => $kveta,
			"firstname" => $kveta->g("firstname"),
			"lastname" => $kveta->g("lastname"),
			"company" => $kveta->g("company"),
			"address_street" => $kveta->g("address_street"),
			"address_street2" => $kveta->g("address_street2"),
			"address_city" => $kveta->g("address_city"),
			"address_state" => $kveta->g("address_state"),
			"address_zip" => $kveta->g("address_zip"),
			"address_country" => $kveta->g("address_country"),
			"phone" => $kveta->g("phone"),
		]);
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);
		$this->assertEquals("Ambrozova 9",$basket->g("delivery_address_street"));
		$this->assertEquals(null,$basket->g("address_street"));
		$basket->destroy();

		// D) Ted bude posledni dorucovaci adresa jina nez fakturacni -> v kosiku budou obe adresy
		$delivery_address->s("address_street","Biskupcova 19");
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);
		$this->assertEquals("Biskupcova 19",$basket->g("delivery_address_street"));
		$this->assertEquals("Ambrozova 9",$basket->g("address_street"));
		$basket->destroy();
	}

	function test_createOrder_integrity_key(){
		$kveta = $this->users["kveta"];
		$czechoslovakia = $this->regions["czechoslovakia"];
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);
		$basket->s(array(
			"delivery_method_id" => $this->delivery_methods["personal"],
			"payment_method_id" => $this->payment_methods["cash_on_delivery"]
		));

		$order = $basket->createOrder();
		$this->assertEquals((string)$basket->getId(),$order->getIntegrityKey());

		// another try to create new order from the same basket must fail with an exception
		$expcetion_thrown = false;
		try {
			@$order = $basket->createOrder();
		}catch(Exception $e){
			$expcetion_thrown = true;
		}
		$this->assertEquals(true,$expcetion_thrown);
	}

	function test_hasEveryProductTag(){
		$tag = $this->tags["fun"];

		$tea_card = $this->cards["tea"];
		$book_card = $this->cards["book"];

		$black_tea = $this->products["black_tea"];
		$green_tea = $this->products["green_tea"];
		$book = $this->products["book"];

		//

		$basket = Basket::CreateNewRecord4UserAndRegion($this->users["kveta"],$this->regions["czechoslovakia"]);
		$this->assertFalse($basket->hasEveryProductTag($tag));

		$basket->addProduct($black_tea);
		$this->assertFalse($basket->hasEveryProductTag($tag));

		$black_tea->addTag($tag);
		$this->assertTrue($basket->hasEveryProductTag($tag));

		$basket->addProduct($book);
		$this->assertFalse($basket->hasEveryProductTag($tag));

		$book->addTag($tag);
		$this->assertFalse($basket->hasEveryProductTag($tag)); // it's because the book is not variant product

		$book_card->addTag($tag);
		$this->assertTrue($basket->hasEveryProductTag($tag));

		$basket->addProduct($green_tea);
		$this->assertFalse($basket->hasEveryProductTag($tag));

		$tea_card->addTag($tag);
		$this->assertTrue($basket->hasEveryProductTag($tag));
	}
}
