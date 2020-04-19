<?php
/**
 *
 * @fixture delivery_methods 
 * @fixture payment_methods
 * @fixture shipping_combinations
 */
class TcShippingCombination extends TcBase {

	function test(){
		$dpd = $this->delivery_methods["dpd"];
		$personal = $this->delivery_methods["personal"];
		$post = $this->delivery_methods["post"];
		$post_cod = $this->delivery_methods["post_cod"];
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
	}
}
