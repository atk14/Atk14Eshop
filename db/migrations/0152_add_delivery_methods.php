<?php
class AddDeliveryMethods extends ApplicationMigration {

	function up() {
		if (TEST) {
			return;
		}

		// ./scripts/console
		//
		// $dbmole->doQuery("DELETE FROM baskets WHERE id!=1");
		// ($dm = DeliveryMethod::FindByCode("cp-balikovna")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("cp-balikovna_cod")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("cp-balik-na-postu")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("cp-balik-na-postu_cod")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("zasilkovna")) && $dm->destroy();
		// ($dm = DeliveryMethod::FindByCode("zasilkovna_cod")) && $dm->destroy();
		//
		// ./scripts/migrate -f 0152_add_delivery_methods.php

		$active = DEVELOPMENT;

		$cp_balikovna = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balikovna",
			"label_en" => "Czech Post - Parcel Delivery To Parcel Pickup Outlet (payment in advance)",
			"label_cs" => "Česká Pošta - Balíkovna (platba předem)",

			"price_incl_vat" => 55,
			"price" => $this->_delVat(55),
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("cp-balikovna"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-do-balikovny.png"),
		]);

		$cp_balikovna_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balikovna_cod",
			"label_en" => "Czech Post - Parcel Delivery To Parcel Pickup Outlet (cash on delivery)",
			"label_cs" => "Česká Pošta - Balíkovna (dobírka)",

			"price_incl_vat" => 75,
			"price" => $this->_delVat(75),
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("cp-balikovna"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-do-balikovny.png"),
		]);

		$cp_balik_na_postu = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balik-na-postu",
			"label_en" => "Czech Post - Parcel Delivery To Post Office (payment in advance)",
			"label_cs" => "Česká Pošta - Balík na poštu (platba předem)",

			"price_incl_vat" => 110,
			"price" => $this->_delVat(110),
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("cp-balik-na-postu"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-na-postu.png"),
		]);

		$cp_balik_na_postu_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "cp-balik-na-postu_cod",
			"label_en" => "Czech Post - Parcel Delivery To Post Office (cash on delivery)",
			"label_cs" => "Česká Pošta - Balík na poštu (dobírka)",

			"price_incl_vat" => 127,
			"price" => $this->_delVat(127),
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("cp-balik-na-postu"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/ceska-posta-balik-na-postu.png"),
		]);

		$zasilkovna = DeliveryMethod::CreateNewRecord( [
			"code" => "zasilkovna",
			"label_en" => "Packeta (payment in advance)",
			"label_cs" => "Zásilkovna (platba předem)",

			"price_incl_vat" => 65,
			"price" => $this->_delVat(65),
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("zasilkovna"),
			"active" => $active,
			"logo" => (string)Pupiq::CreateImage(__DIR__ . "/logos/zasilkovna.png"),
		]);

		$zasilkovna_cod = DeliveryMethod::CreateNewRecord( [
			"code" => "zasilkovna_cod",
			"label_en" => "Packeta (cash on delivery)",
			"label_cs" => "Zásilkovna (dobírka)",

			"price_incl_vat" => 85,
			"price" => $this->_delVat(85),
			"regions" => json_encode(["DEFAULT" => true]),

			"delivery_service_id" => DeliveryService::GetInstanceByCode("zasilkovna"),
			"active" => $active,
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

		if($dm = DeliveryMethod::GetInstanceByCode("personal")){
			$dm->setRank(999);
		}
	}

	function _delVat($price){
		$price = ($price / 121.0) * 100.0;
		$price = round($price,2);
		return $price;
	}
}
