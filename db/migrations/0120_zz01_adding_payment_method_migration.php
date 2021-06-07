<?php
class Zz01AddingPaymentMethodMigration extends ApplicationMigration {

	function up(){
		$pay_u_gateway = PaymentGateway::GetInstanceByCode("pay_u");
		myAssert($pay_u_gateway);
		
		$pay_u = PaymentMethod::CreateNewRecord([
			"code" => "pay_u",
			"regions" => '{"DEFAULT": true}',
			"payment_gateway_id" => $pay_u_gateway,
			"bank_transfer" => false,
			"cash_on_delivery" => false,
			"label_en" => "Online payment via PayU payment gateway",
			"label_cs" => "Online platba přes platební bránu PayU",
			"price_incl_vat" => 0,
		]);

		foreach(["cpost","digital_delivery","cp-balikovna","cp-balik-na-postu","zasilkovna","personal"] as $code){
			$dm = DeliveryMethod::GetInstanceByCode($code);
			if(!$dm){ continue; }
			ShippingCombination::CreateNewRecord([
				"delivery_method_id" => $dm,
				"payment_method_id" => $pay_u,
			]);
		}
	}
}
