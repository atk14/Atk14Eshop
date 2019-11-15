<?php
class FulfillingOrderStatusesMigration extends ApplicationMigration {

	function up(){
		OrderStatus::CreateNewRecord([
			"id" => 1,
			"code" => "new",
			"name_en" => "New order",
			"name_cs" => "Nová objednavka",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 10,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 2,
			"code" => "waiting_for_bank_transfer",
			"name_en" => "Waiting for payment by bank transfer",
			"name_cs" => "Čekání na úhradu bankovním převodem",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 20,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 3,
			"code" => "waiting_for_online_payment",
			"name_en" => "Waiting for payment gateway processing",
			"name_cs" => "Čekání na zpracování platební bránou",
			"notification_enabled" => false,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 30,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 4,
			"code" => "payment_accepted",
			"name_en" => "Payment received",
			"name_cs" => "Platba byla přijata",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 40,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 5,
			"code" => "payment_failed",
			"name_en" => "Payment not made",
			"name_cs" => "Platba nebyla uskutečněna",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 50,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 6,
			"code" => "processing",
			"name_en" => "Order processing started",
			"name_cs" => "Zahájeno zpracování objednávky",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 60,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 7,
			"code" => "shipped",
			"name_en" => "Shipped",
			"name_cs" => "Předáno dopravci",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => true,
			"rank"  => 70,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 8,
			"code" => "ready_for_pickup",
			"name_en" => "Ready for pickup",
			"name_cs" => "Připraveno k vyzvednutí na odběrném místě",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 80,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 9,
			"code" => "delivered",
			"name_en" => "Delivered",
			"name_cs" => "Doručeno",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => true,
			"rank"  => 90,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 10,
			"code" => "cancelled",
			"name_en" => "Cancelled",
			"name_cs" => "Zrušeno",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => false,
			"rank"  => 100,
		]);

		OrderStatus::CreateNewRecord([
			"id" => 11,
			"code" => "returned",
			"name_en" => "Order was returned",
			"name_cs" => "Objednávka byla vrácena",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => false,
			"rank"  => 110,
		]);
	}
}
