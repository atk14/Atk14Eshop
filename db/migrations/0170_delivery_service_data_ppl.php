<?php
class DeliveryServiceDataPPL extends ApplicationMigration {

	function up() {

		if (TEST) {
			// In testing, we load the rest from fixtures
			return;
		}

		$services = [
			[
				"code" => "ppl",
				"name" => "PPL",
			],
		];

		foreach($services as $values) {
			DeliveryService::CreateNewRecord($values);
		}

		$active = DEVELOPMENT;

		$ppl = DeliveryMethod::CreateNewRecord( [
			"code" => "ppl_parcel_smart",
			"label_en" => "PPL Parcel Smart (payment in advance)",
			"label_cs" => "PPL Parcel Smart (platba předem)",

			"price_incl_vat" => 65,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("ppl"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ppl-flexi.png"),
		]);

		$ppl_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "ppl_parcel_smart_cod",
			"label_en" => "PPL Parcel Smart (cash on delivery)",
			"label_cs" => "PPL Parcel Smart (dobírka)",

			"price_incl_vat" => 85,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("ppl"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ppl-flexi.png"),
		]);

		$bank_transfer = PaymentMethod::GetInstanceByCode("bank_transfer");
		$cash_on_delivery = PaymentMethod::GetInstanceByCode("cash_on_delivery");

		ShippingCombination::SetPaymentMethodsForDeliveryMethod($ppl, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($ppl_cod, [$cash_on_delivery]);
	}
}
