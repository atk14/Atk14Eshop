<?php
class Zz04AddingGpWebpayPaymentMethodMigration extends ApplicationMigration {

	function up(){
		$gateway = PaymentGateway::GetInstanceByCode("gp_webpay");
		myAssert($gateway);
		
		$pm = PaymentMethod::CreateNewRecord([
			"code" => "gp_webpay",
			"regions" => '{"DEFAULT": true}',
			"payment_gateway_id" => $gateway,
			"bank_transfer" => false,
			"cash_on_delivery" => false,
			"label_en" => "Online payment via GP webpay payment gateway",
			"label_cs" => "Online platba přes GP webpay platební bránu",
			"price_incl_vat" => 0,
			"active" => false,
		]);

		foreach(["cpost","digital_delivery","cp-balikovna","cp-balik-na-postu","zasilkovna","personal"] as $code){
			$dm = DeliveryMethod::GetInstanceByCode($code);
			if(!$dm){ continue; }
			ShippingCombination::CreateNewRecord([
				"delivery_method_id" => $dm,
				"payment_method_id" => $pm,
			]);
		}
	}
}
