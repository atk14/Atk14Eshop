<?php
class Zz01AddMoreDeliveryMethods extends ApplicationMigration {

	function up() {
		if (TEST) {
			return;
		}

		$active = DEVELOPMENT;

		$region = Region::GetDefaultRegion();
		$region_code = $region->getCode();

		$cp_balikovna_to_address = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balikovna_to_address",
			"label_en" => "Czech Post - Parcel Delivery to Your Address (payment in advance)",
			"label_cs" => "Česká Pošta - Balíkovna na adresu (platba předem)",

			"price_incl_vat" => 55,
			"regions" => json_encode([$region_code => true]),

			"delivery_service_id" => null,
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/balikovna-balik-na-adresu.png"),
		]);

		$cp_balikovna_to_address_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balikovna_to_address_cod",
			"label_en" => "Czech Post - Parcel Delivery to Your Address (cash on delivery)",
			"label_cs" => "Česká Pošta - Balíkovna na adresu (dobírka)",

			"price_incl_vat" => 75,
			"regions" => json_encode([$region_code => true]),

			"delivery_service_id" => null,
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/balikovna-balik-na-adresu.png"),
		]);

		$zasilkovna_to_address = DeliveryMethod::CreateNewRecord( [
			"code" => "zasilkovna_to_address",
			"label_en" => "Packeta to Your Address (payment in advance)",
			"label_cs" => "Zásilkovna na adresu (platba předem)",

			"price_incl_vat" => 65,
			"regions" => json_encode([$region_code => true]),

			"delivery_service_id" => null,
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/zasilkovna.png"),
		]);

		$zasilkovna_to_address_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "zasilkovna_to_address_cod",
			"label_en" => "Packeta to Your Address (cash on delivery)",
			"label_cs" => "Zásilkovna na adresu (dobírka)",

			"price_incl_vat" => 85,
			"regions" => json_encode([$region_code => true]),

			"delivery_service_id" => null,
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/zasilkovna.png"),
		]);

		$bank_transfer = PaymentMethod::GetInstanceByCode("bank_transfer");
		$cash_on_delivery = PaymentMethod::GetInstanceByCode("cash_on_delivery");

		ShippingCombination::SetPaymentMethodsForDeliveryMethod($cp_balikovna_to_address, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($cp_balikovna_to_address_cod, [$cash_on_delivery]);

		ShippingCombination::SetPaymentMethodsForDeliveryMethod($zasilkovna_to_address, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($zasilkovna_to_address_cod, [$cash_on_delivery]);
	}
}
