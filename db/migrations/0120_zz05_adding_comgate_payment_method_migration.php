<?php
class Zz05AddingComgatePaymentMethodMigration extends ApplicationMigration {

	function up(){
		if(PaymentMethod::GetInstanceByCode("comgate")){ return; }

		$gateway = PaymentGateway::GetInstanceByCode("comgate");
		myAssert($gateway);

		$region = Region::GetDefaultRegion();
		$regions = $region ? sprintf('{"%s": true}',$region->getCode()) : '{}';

		$pm = PaymentMethod::CreateNewRecord([
			"code" => "comgate",
			"regions" => $regions,
			"payment_gateway_id" => $gateway,
			"bank_transfer" => false,
			"cash_on_delivery" => false,
			"label_en" => "Online payment via Comgate payment gateway",
			"label_cs" => "Online platba přes platební bránu Comgate",
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
