<?php
class DeliveryServicesDataWEDO extends ApplicationMigration {

	function up() {

		if (TEST) {
			// In testing, we load the rest from fixtures
			return;
		}

		$services = [
			[
				"code" => "wedo_ulozenka",
				"name" => "WE|DO",
			],
		];

		foreach($services as $values) {
			DeliveryService::CreateNewRecord($values);
		}

		$active = DEVELOPMENT;

		$wedo = DeliveryMethod::CreateNewRecord( [
			"code" => "ulozenka",
			"label_en" => "Uloženka (payment in advance)",
			"label_cs" => "Uloženka (platba předem)",

			"price_incl_vat" => 65,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("wedo_ulozenka"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/we-do.png"),
		]);

		$wedo_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "ulozenka_cod",
			"label_en" => "Uloženka (cash on delivery)",
			"label_cs" => "Uloženka (dobírka)",

			"price_incl_vat" => 85,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("ulozenka"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/we-do.png"),
		]);

		$bank_transfer = PaymentMethod::GetInstanceByCode("bank_transfer");
		$cash_on_delivery = PaymentMethod::GetInstanceByCode("cash_on_delivery");


		ShippingCombination::SetPaymentMethodsForDeliveryMethod($wedo, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($wedo_cod, [$cash_on_delivery]);

	}
}
