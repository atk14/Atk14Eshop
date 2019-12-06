<?php
class PaymentAndDeliveryMethodsMigration extends ApplicationMigration {

	function up(){
		$cpost = DeliveryMethod::CreateNewRecord([
			"code" => "cpost",
			"regions" => '{"DEFAULT": true}',
			"label_en" => "Czech Post (payment in advance)",
			"label_cs" => "Česká pošta (platba předem)",
			"title_en" => "Czech Post (payment in advance)",
			"title_cs" => "Česká pošta (platba předem)",
			"description_en" => "Shipment dispatch is realized after payment is credited to our bank account.",
			"description_cs" => "Expedice je realizována po připsání platby na náš bankovní účet.",
			"logo" => "http://i.pupiq.net/i/65/65/287/29287/250x250/Dxhnpz_250x250_e809c1d63dcd0c16.png",
			"price" => 90,
			"price_incl_vat" => 90,
		]);

		$cpost_cod = DeliveryMethod::CreateNewRecord([
			"code" => "cpost_cod",
			"regions" => '{"DEFAULT": true}',
			"label_en" => "Czech Post (cash on delivery)",
			"label_cs" => "Česká pošta (dobírka)",
			"title_en" => "Czech Post (cash on delivery)",
			"title_cs" => "Česká pošta (dobírka)",
			"description_en" => "Payment is made after receiving the shipment from the carrier.",
			"description_cs" => "Platba je realizována až při převzetí u dopravce.",
			"logo" => "http://i.pupiq.net/i/65/65/287/29287/250x250/Dxhnpz_250x250_e809c1d63dcd0c16.png",
			"price" => 120,
			"price_incl_vat" => 120,
		]);

		$personal = DeliveryMethod::CreateNewRecord([
			"code" => "personal",
			"regions" => '{"DEFAULT": true}',
			"label_en" => "Personal pickup at the store",
			"label_cs" => "Osobní převzetí na prodejně",
			"title_en" => "Personal pickup at the store",
			"title_cs" => "Osobní prodejně na prodejně",
			"personal_pickup" => true,
			"personal_pickup_on_store_id" => Store::FindFirst(),
			"price" => 0,
			"price_incl_vat" => 0,
		]);

		$bank_transfer = PaymentMethod::CreateNewRecord([
			"code" => "bank_transfer",
			"regions" => '{"DEFAULT": true}',
			"label_en" => "Bank transfer",
			"label_cs" => "Bankovní převod",
			"title_en" => "Bank transfer",
			"title_cs" => "Bankovní převod",
			"price" => 0,
			"price_incl_vat" => 0,
		]);

		$cash_on_delivery = PaymentMethod::CreateNewRecord([
			"code" => "cash_on_delivery",
			"regions" => '{"DEFAULT": true}',
			"label_en" => "Cash on delivery",
			"label_cs" => "Zaplatit dobírkou, zaplatíte až při převzetí",
			"title_en" => "Cash on delivery",
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