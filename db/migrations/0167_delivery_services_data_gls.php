<?php
class DeliveryServicesDataGLS extends ApplicationMigration {

	function up() {

		if (TEST) {
			// In testing, we load the rest from fixtures
			return;
		}

		$services = [
			[
				"code" => "gls",
				"name" => "GLS",
			],
		];

		foreach($services as $values) {
			DeliveryService::CreateNewRecord($values);
		}

		$active = DEVELOPMENT;

		$gls = DeliveryMethod::CreateNewRecord( [
			"code" => "gls_parcel_shop",
			"label_en" => "GLS (payment in advance)",
			"label_cs" => "GLS (platba předem)",

			"price_incl_vat" => 65,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("gls"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/gls.png"),
		]);

		$gls_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "gls_parcel_shop_cod",
			"label_en" => "GLS (cash on delivery)",
			"label_cs" => "GLS (dobírka)",

			"price_incl_vat" => 85,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("gls"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/gls.png"),
		]);

		$bank_transfer = PaymentMethod::GetInstanceByCode("bank_transfer");
		$cash_on_delivery = PaymentMethod::GetInstanceByCode("cash_on_delivery");


		ShippingCombination::SetPaymentMethodsForDeliveryMethod($gls, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($gls_cod, [$cash_on_delivery]);

	}
}
