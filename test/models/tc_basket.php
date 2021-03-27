<?php
/**
 *
 * @fixture regions
 * @fixture users
 * @fixture vouchers
 * @fixture campaigns
 * @fixture delivery_methods
 * @fixture payment_methods
 * @fixture shipping_combinations
 * @fixture cards
 * @fixture products
 * @fixture pricelist_items
 * @fixture warehouse_items
 * @fixture tags
 * @fixture delivery_services
 * @fixture delivery_service_branches
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

	function test_addProduct(){
		$mint_tea = $this->products["mint_tea"];
		$black_tea = $this->products["black_tea"];

		$kveta = $this->users["kveta"];
		$czechoslovakia = $this->regions["czechoslovakia"];
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);

		$this->assertEquals(true,$basket->isEmpty());
		$this->assertEquals(0,sizeof($basket->getItems()));

		$basket->addProduct($mint_tea,2);
		$items = $basket->getItems();
		$this->assertEquals(1,sizeof($items));
		$this->assertEquals($mint_tea->getId(),$items[0]->getProductId());
		$this->assertEquals(2,$items[0]->getAmount());

		$basket->addProduct($mint_tea,1);
		$items = $basket->getItems();
		$this->assertEquals(1,sizeof($items));
		$this->assertEquals($mint_tea->getId(),$items[0]->getProductId());
		$this->assertEquals(1,$items[0]->getAmount()); // amount rewritten
		
		$basket->addProduct($mint_tea,3,["rewrite_amount" => false]);
		$items = $basket->getItems();
		$this->assertEquals(1,sizeof($items));
		$this->assertEquals($mint_tea->getId(),$items[0]->getProductId());
		$this->assertEquals(4,$items[0]->getAmount()); // amount increased

		$basket->addProduct($black_tea);
		$items = $basket->getItems();
		$this->assertEquals(2,sizeof($basket->getItems()));
		$this->assertEquals($black_tea->getId(),$items[0]->getProductId()); // last added product
		$this->assertEquals($mint_tea->getId(),$items[1]->getProductId());

		$basket->addProduct($mint_tea,1,["update_rank" => false]);
		$items = $basket->getItems();
		$this->assertEquals(2,sizeof($basket->getItems()));
		$this->assertEquals($black_tea->getId(),$items[0]->getProductId());
		$this->assertEquals($mint_tea->getId(),$items[1]->getProductId()); // last added product
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

	function test_price(){
		$kveta = $this->users["kveta"];
		$czechoslovakia = $this->regions["czechoslovakia"];
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);

		$basket->addProduct($this->products["mint_tea"],2);

		$items = $basket->getItems();
		$item = $items[0];

		$this->assertEquals(20.0,$item->getUnitPrice());
		$this->assertEquals(24.2,$item->getUnitPriceInclVat());
		$this->assertEquals(40.0,$item->getPrice());
		$this->assertEquals(48.4,$item->getPriceInclVat());
	}

	function test_merge(){
		$basket1 = Basket::CreateNewRecord([]);
		$basket2 = Basket::CreateNewRecord([]);

		$basket1->getVouchersLister()->add($this->vouchers["free_shipping"]);
		$basket1->getVouchersLister()->add($this->vouchers["percentage_discount"]);

		$basket2->getVouchersLister()->add($this->vouchers["percentage_discount"]);

		$basket2->mergeBasket($basket1);

		$vouchers = $basket2->getVouchers();
		$this->assertEquals(2,sizeof($vouchers));

		$this->assertEquals($this->vouchers["percentage_discount"]->getId(),$vouchers[0]->getVoucherId());
		$this->assertEquals($this->vouchers["free_shipping"]->getId(),$vouchers[1]->getVoucherId());
	}

	function test_getCampaigns(){
		$basket = Basket::CreateNewRecord([
			"region_id" => $this->regions["czechoslovakia"]
		]);
		$this->assertEquals([],$basket->getCampaigns());
		$this->assertEquals(false,$basket->freeShipping());

		$campaing = Campaign::CreateNewRecord([
			"regions" => json_encode([$this->regions["czechoslovakia"]->getCode() => true]),
			"minimal_items_price_incl_vat" => 0.0,
			"discount_percent" => 0.0,
			"free_shipping" => true,
		]);

		$campaings = $basket->getCampaigns();
		$this->assertEquals(1,sizeof($campaings));
		$this->assertEquals($campaing->getId(),$campaings[0]->getCampaign()->getId());
		$this->assertEquals(true,$basket->freeShipping());

		// podminime kampan dopravou od DPD
		$dpd = $this->delivery_methods["dpd"];
		$parcel_service = $this->delivery_methods["parcel_service"];

		$campaing->s([
			"delivery_method_id" => $dpd,
		]);

		$campaings = $basket->getCampaigns();
		$this->assertEquals(0,sizeof($campaings));
		$this->assertEquals(false,$basket->freeShipping());

		$basket->s([
			"delivery_method_id" => $parcel_service,
		]);
		$this->assertEquals([],$basket->getCampaigns());
		$this->assertEquals(false,$basket->freeShipping());

		$basket->s([
			"delivery_method_id" => $dpd,
		]);
		$campaings = $basket->getCampaigns();
		$this->assertEquals(1,sizeof($campaings));
		$this->assertEquals($campaing->getId(),$campaings[0]->getCampaign()->getId());
		$this->assertEquals(true,$basket->freeShipping());
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

	/**
	 * Test, ze s vyberem dorucovaci sluzby s pobockami je zvolena i pobocka
	 */
	function test_delivery_service_needs_delivery_branch() {
		$lang = "en";
		Atk14Locale::Initialize($lang);

		$basket = Basket::CreateNewRecord([
			"region_id" => $this->regions["czechoslovakia"]
		]);
		$basket->addProduct($this->products["mint_tea"], 5);

		$basket->s([
			"delivery_method_id" => $this->delivery_methods["zasilkovna"]->getId(),
			"payment_method_id" => $this->payment_methods["bank_transfer"]->getId(),
		]);
		$this->assertFalse($basket->canOrderBeCreated($messages));
		$this->assertCount(1, $messages);
		$this->assertEquals("Delivery address has not been selected for the shipping method 'Packeta'", (string)$messages[0]);

		$basket->s("delivery_method_data", $this->delivery_service_branches["zasilkovna_1"]->getDeliveryMethodData());
		$this->assertTrue($basket->canOrderBeCreated($messages));
	}

	function test_canOrderBeCreated(){
		Atk14Locale::Initialize(); // TODO: it is not clear why this is needed, certainly it should be handled on another place

		$kveta = $this->users["kveta"];
		$czechoslovakia = $this->regions["czechoslovakia"];
		$basket = Basket::CreateNewRecord4UserAndRegion($kveta,$czechoslovakia);
		$basket->s([
			"delivery_method_id" => $this->delivery_methods["post"],
			"payment_method_id" => $this->payment_methods["bank_transfer"],
		]);

		$this->assertFalse($basket->canOrderBeCreated($messages));
		$this->assertEquals(1,sizeof($messages));
		$this->assertEquals("Shopping basket is empty",(string)$messages[0]);

		$basket->addProduct($this->products["black_tea"]);
		$stat = $basket->canOrderBeCreated($messages);
		$this->assertTrue($stat);
		$this->assertEquals(0,sizeof($messages));

		$basket->addProduct($this->products["herbal_tea"]);
		$stat = $basket->canOrderBeCreated($messages);
		$this->assertFalse($stat);
		$this->assertEquals(1,sizeof($messages));
		$this->assertEquals("Product <em>Herbal tea (HERBAL_TEA)</em> is out of stock",(string)$messages[0]);

		$basket->setProductAmount($this->products["herbal_tea"],0);
		$stat = $basket->canOrderBeCreated($messages);
		$this->assertTrue($stat);

		$basket->addProduct($this->products["green_tea"]);
		$stat = $basket->canOrderBeCreated($messages);
		$this->assertFalse($stat);
		$this->assertEquals(1,sizeof($messages));
		$this->assertEquals("Product <em>Green tea (TEA_GREEN)</em> has been removed from our price list",(string)$messages[0]);

		$basket->setProductAmount($this->products["green_tea"],0);
		$stat = $basket->canOrderBeCreated($messages);
		$this->assertTrue($stat);

		// choosing unsupported shipping combination
		$basket->s([
			"delivery_method_id" => $this->delivery_methods["post_cod"],
			"payment_method_id" => $this->payment_methods["bank_transfer"],
		]);
		$this->assertNotNull($basket->getDeliveryMethod());
		$this->assertNotNull($basket->getPaymentMethod());
		$stat = $basket->canOrderBeCreated($messages);
		$this->assertFalse($stat);
		$this->assertEquals(0,sizeof($messages)); // there is no message
		$this->assertNull($basket->getDeliveryMethod());
		$this->assertNull($basket->getPaymentMethod());
	}
}
