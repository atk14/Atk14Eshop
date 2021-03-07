<?php
class AddDeliveryMethods extends Atk14Migration {

	function up() {
		if (TEST) {
			return;
		}

		// ($dm = DeliveryMethod::FindByCode("cp-balikovna")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("cp-balikovna_cod")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("cp-balik-na-postu")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("cp-balik-na-postu_cod")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("zasilkovna")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("zasilkovna_cod")) && $dm->destroy();

		$cp_balikovna = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balikovna",
			"label_en" => "Czech Post - Parcel Delivery To Parcel Pickup Outlet",
			"label_cs" => "Česká Pošta - Balíkovna",

			"price" => 0,
			"price_incl_vat" => 0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "cp-balikovna"),
			"active" => false,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-do-balikovny.png"),
		]);

		$cp_balikovna_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balikovna_cod",
			"label_en" => "Czech Post - Parcel Delivery To Parcel Pickup Outlet (cash on delivery)",
			"label_cs" => "Česká Pošta - Balíkovna (dobírka)",

			"price" => 0,
			"price_incl_vat" => 0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "cp-balikovna"),
			"active" => false,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-do-balikovny.png"),
		]);

		$cp_balik_na_postu = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balik-na-postu",
			"label_en" => "Czech Post - Parcel Delivery To Post Office",
			"label_cs" => "Česká Pošta - Balík na poštu",

			"price" => 49.0/122*100,
			"price_incl_vat" => 49.0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "cp-balik-na-postu"),
			"active" => false,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-na-postu.png"),
		]);

		$cp_balik_na_postu_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balik-na-postu_cod",
			"label_en" => "Czech Post - Parcel Delivery To Post Office (cash on delivery)",
			"label_cs" => "Česká Pošta - Balík na poštu (dobírka)",

			"price" => 49.0/122*100,
			"price_incl_vat" => 49.0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "cp-balik-na-postu"),
			"active" => false,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-na-postu.png"),
		]);

		$zasilkovna = DeliveryMethod::CreateNewRecord( [
			"code" => "zasilkovna",
			"label_en" => "Packeta",
			"label_cs" => "Zásilkovna",

			"price" => 0,
			"price_incl_vat" => 0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "zasilkovna"),
			"active" => false,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/zasilkovna.png"),
		]);

		$zasilkovna_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "zasilkovna_cod",
			"label_en" => "Packeta (cash on delivery)",
			"label_cs" => "Zásilkovna (dobírka)",

			"price" => 0,
			"price_incl_vat" => 0,
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::FindFirst("code", "zasilkovna"),
			"active" => false,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/zasilkovna.png"),
		]);

		$bank_transfer = PaymentMethod::GetInstanceByCode("bank_transfer");
		$cash_on_delivery = PaymentMethod::GetInstanceByCode("cash_on_delivery");

		ShippingCombination::SetPaymentMethodsForDeliveryMethod($cp_balikovna, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($cp_balikovna_cod, [$cash_on_delivery]);

		ShippingCombination::SetPaymentMethodsForDeliveryMethod($cp_balik_na_postu, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($cp_balik_na_postu_cod, [$cash_on_delivery]);

		ShippingCombination::SetPaymentMethodsForDeliveryMethod($zasilkovna, [$bank_transfer]);
		ShippingCombination::SetPaymentMethodsForDeliveryMethod($zasilkovna_cod, [$cash_on_delivery]);
	}
}
