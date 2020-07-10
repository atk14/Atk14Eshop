<?php
class AddDeliveryMethods extends Atk14Migration {
	function up() {

		$dm = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balikovna",
			"label_cs" => "Česká Pošta - Balíkovna",
			"title_cs" => "Česká Pošta - Balíkovna",
			"label_en" => "Česká Pošta - Balíkovna",
			"title_en" => "Česká Pošta - Balíkovna",

			"price" => 0,
			"price_incl_vat" => 0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "cp-balikovna"),
			"active" => false,
		]);

		$dm = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balik-na-postu",
			"label_cs" => "Česká Pošta - Balík na poštu",
			"title_cs" => "Česká Pošta - Balík na poštu",
			"label_en" => "Česká Pošta - Balík na poštu",
			"title_en" => "Česká Pošta - Balík na poštu",

			"price" => 49.0/122*100,
			"price_incl_vat" => 49.0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "cp-balik-na-postu"),
			"active" => false,
		]);

		$dm = DeliveryMethod::CreateNewRecord( [
			"code" => "zasilkovna",
			"label_cs" => "Zásilkovna",
			"title_cs" => "Zásilkovna",
			"label_en" => "Zásilkovna",
			"title_en" => "Zásilkovna",

			"price" => 0,
			"price_incl_vat" => 0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "zasilkovna"),
			"active" => false,
		]);

		ShippingCombination::SetPaymentMethodsForDeliveryMethod(DeliveryMethod::FindFirst("code", "cp-balikovna"), [ PaymentMethod::FindFirst("code", "cash_on_delivery"), PaymentMethod::FindFirst("code", "bank_transfer")]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod(DeliveryMethod::FindFirst("code", "cp-balik-na-postu"), [ PaymentMethod::FindFirst("code", "cash_on_delivery"), PaymentMethod::FindFirst("code", "bank_transfer")]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod(DeliveryMethod::FindFirst("code", "zasilkovna"), [ PaymentMethod::FindFirst("code", "cash_on_delivery"), PaymentMethod::FindFirst("code", "bank_transfer")]);
	}
}
