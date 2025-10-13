<?php
/**
 *
 * @fixture delivery_services
 * @fixture delivery_methods
 * @fixture payment_methods
 * @fixture shipping_combinations
 * @fixture products
 * @fixture card_tags
 * @fixture tags
 */
class TcShippingCombination extends TcBase {

	function ___tetst(){
		$dpd = $this->delivery_methods["dpd"];
		$personal = $this->delivery_methods["personal"];
		$post = $this->delivery_methods["post"];
		$post_cod = $this->delivery_methods["post_cod"];
		$zasilkovna = $this->delivery_methods["zasilkovna"];
		//
		$credit_card = $this->payment_methods["credit_card"];
		$bank_transfer = $this->payment_methods["bank_transfer"];
		$cash_on_delivery = $this->payment_methods["cash_on_delivery"];

		$this->assertTrue(ShippingCombination::IsAllowed($dpd,$credit_card));
		$this->assertFalse(ShippingCombination::IsAllowed($dpd,$cash_on_delivery));
		
		$this->assertTrue(ShippingCombination::IsAllowed($personal,$cash_on_delivery));
		$this->assertFalse(ShippingCombination::IsAllowed($personal,$credit_card));

		$this->assertTrue(ShippingCombination::IsAllowed($post,$bank_transfer));
		$this->assertFalse(ShippingCombination::IsAllowed($post,$cash_on_delivery));

		$this->assertTrue(ShippingCombination::IsAllowed($post_cod,$cash_on_delivery));
		$this->assertFalse(ShippingCombination::IsAllowed($post_cod,$bank_transfer));

		# bez api key neni kombinace se Zasilkovnou povolena
		$sys_param = SystemParameter::GetInstanceByCode("delivery_services.zasilkovna.api_key");
		$sys_param->s("content",null);
		$this->assertFalse(ShippingCombination::IsAllowed($zasilkovna, $bank_transfer));
		# ted kdyz doplnime api key
		$sys_param->s("content","12345");
		# je kombinace se Zasilkovnou povolena
		$this->assertTrue(ShippingCombination::IsAllowed($zasilkovna, $bank_transfer));

		$basket = Basket::CreateNewRecord4UserAndRegion(User::GetAnonymousUser(),Region::GetDefaultRegion());

		list($delivery_methods,$payment_methods) = ShippingCombination::GetAvailableMethods4Basket($basket);
		$this->assertTrue(sizeof($delivery_methods)>0);
		$this->assertTrue(is_a($delivery_methods[0],"DeliveryMethod"));
		$this->assertTrue(sizeof($payment_methods)>0);
		$this->assertTrue(is_a($payment_methods[0],"PaymentMethod"));

		list($delivery_methods_no_cod,$payment_methods_no_cod) = ShippingCombination::GetAvailableMethods4Basket($basket,["cash_on_delivery_enabled" => false]);
		$this->assertTrue(sizeof($delivery_methods_no_cod)>0);
		$this->assertTrue(sizeof($payment_methods_no_cod)>0);
		$this->assertTrue(sizeof($delivery_methods)>sizeof($delivery_methods_no_cod));
		$this->assertTrue(sizeof($payment_methods)>sizeof($payment_methods_no_cod));

    //
		$this->assertTrue(null == ShippingCombination::IsAllowed($dpd,null));
		$this->assertTrue(null == ShippingCombination::IsAllowed(null,$credit_card));
		$this->assertTrue(null == ShippingCombination::IsAllowed(null,null));

		// *Digital product download* is an exclusive delivery method for digital products

		$this->assertTrue($basket->isEmpty());

		$basket->addProduct($this->products["strih_v_pdf_formatu"]);
		list($delivery_methods,$payment_methods) = ShippingCombination::GetAvailableMethods4Basket($basket);

		$this->assertEquals(1,sizeof($delivery_methods));
		$labels = array_map(function($dm){ return $dm->getLabel(); },$delivery_methods);
		$this->assertTrue(in_array("Digital product download",$labels));

		$basket->addProduct($this->products["green_tea"]);
		list($delivery_methods,$payment_methods) = ShippingCombination::GetAvailableMethods4Basket($basket);

		$this->assertTrue(sizeof($delivery_methods)>0);
		$labels = array_map(function($dm){ return $dm->getLabel(); },$delivery_methods);
		$this->assertTrue(!in_array("Digital product download",$labels));
	}

	function ___tetst_excluded_tags(){
		$fun = $this->tags["fun"];
		$dpd = $this->delivery_methods["dpd"];
		$peanuts = $this->products["peanuts"];
		$peanuts->getCard()->getTagsLister()->add($fun);
		$dpd->getExcludedForTagsLister()->add($fun);

		$basket = Basket::CreateNewRecord([]);

		list($delivery_methods_empty,$payment_methods_empty) = ShippingCombination::GetAvailableMethods4Basket($basket);

		$basket->setProductAmount($peanuts,1);
		$this->assertFalse($basket->isEmpty());

		list($delivery_methods,$payment_methods) = ShippingCombination::GetAvailableMethods4Basket($basket);

		$this->assertTrue(sizeof($delivery_methods_empty)>sizeof($delivery_methods));
	}

	function test_GetAvailableMethods4Product(){
		list($delivery_methods,$payment_methods) = ShippingCombination::GetAvailableMethods4Product($this->products["arabica"]);
		$this->assertTrue(sizeof($delivery_methods)>5);
		$this->assertTrue(sizeof($payment_methods)>1);

		foreach(DeliveryMethod::FindAll() as $dm){
			if($dm->getCode()==="europallet"){
				$dm->getDesignatedForTagsLister()->add($this->tags["oversized_product"]);
				continue;
			}
			$dm->getExcludedForTagsLister()->add($this->tags["oversized_product"]);
		}
		list($delivery_methods,$payment_methods) = ShippingCombination::GetAvailableMethods4Product($this->products["fridge"]);
		$this->assertEquals(1,sizeof($delivery_methods));
		$this->assertEquals("europallet",$delivery_methods[0]->getCode());
	}
}
