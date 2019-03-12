<?php
class PaymentAndDeliveryMethodsMigration extends ApplicationMigration {

	function up(){
		$cpost = DeliveryMethod::CreateNewRecord([
			"code" => "cpost",
			"regions" => '{"CZ": true}',
			"label_cs" => "Česká pošta (platba předem)",
			"title_cs" => "Česká pošta (platba předem)",
			"description_cs" => "Expedice je realizována po připsání platby na náš bankovní účet.",
			"price" => 90,
			"price_incl_vat" => 90,
		]);

		$cpost_cod = DeliveryMethod::CreateNewRecord([
			"code" => "cpost_cod",
			"regions" => '{"CZ": true}',
			"label_cs" => "Česká pošta (dobírka)",
			"title_cs" => "Česká pošta (dobírka)",
			"description_cs" => "Platba je realizována až při převzetí u dopravce.",
			"price" => 120,
			"price_incl_vat" => 120,
		]);

		$personal = DeliveryMethod::CreateNewRecord([
			"code" => "personal",
			"regions" => '{"CZ": true}',
			"label_cs" => "Osobní převzetí na prodejně",
			"title_cs" => "Osobní prodejně na prodejně",
			"personal_pickup" => true,
			"personal_pickup_on_store_id" => Store::FindFirst(),
			"price" => 0,
			"price_incl_vat" => 0,
		]);

		$bank_transfer = PaymentMethod::CreateNewRecord([
			"code" => "bank_transfer",
			"regions" => '{"CZ": true}',
			"label_cs" => "Bankovní převod",
			"title_cs" => "Bankovní převod",
			"price" => 0,
			"price_incl_vat" => 0,
		]);

		$cash_on_delivery = PaymentMethod::CreateNewRecord([
			"code" => "cash_on_delivery",
			"regions" => '{"CZ": true}',
			"label_cs" => "Zaplatit dobírkou, zaplatíte až při převzetí",
			"title_cs" => "Zaplatit dobírkou, zaplatíte až při převzetí",
			"price" => 0,
			"price" => 0,
		]);

		ShippingCombination::CreateNewRecord([
			"delivery_method_id" => $cpost,
			"payment_method_id" => $bank_transfer,
		]);

		ShippingCombination::CreateNewRecord([
			"delivery_method_id" => $cpost_cod,
			"payment_method_id" => $cash_on_delivery,
		]);

		ShippingCombination::CreateNewRecord([
			"delivery_method_id" => $personal,
			"payment_method_id" => $cash_on_delivery,
		]);
	}
}
