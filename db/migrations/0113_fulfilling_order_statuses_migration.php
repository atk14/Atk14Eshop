<?php
/**
 *
 * This migration can be safely repeat again and again.
 */
class FulfillingOrderStatusesMigration extends ApplicationMigration {

	function up(){

		$values_ar = [];

		$values_ar[] = [
			"id" => 1,
			"code" => "new",
			"name_en" => "New order",
			"name_cs" => "Nová objednávka",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 10,
		];

		$values_ar[] = [
			"id" => 3,
			"code" => "waiting_for_online_payment",
			"name_en" => "Waiting for payment gateway processing",
			"name_cs" => "Čekání na zpracování platební bránou",
			"notification_enabled" => false,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 20,
		];

		$values_ar[] = [
			"id" => 2,
			"code" => "waiting_for_bank_transfer",
			"name_en" => "Request for payment by bank transfer",
			"name_cs" => "Výzva k úhradě bankovním převodem",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 30,
		];

		$values_ar[] = [
			"id" => 13,
			"code" => "repeated_payment_request",
			"name_en" => "Repeated payment request",
			"name_cs" => "Opakovaná výzva k platbě",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 35,
		];

		$values_ar[] = [
			"id" => 4,
			"code" => "payment_accepted",
			"name_en" => "Payment received",
			"name_cs" => "Platba byla přijata",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 40,
		];

		$values_ar[] = [
			"id" => 5,
			"code" => "payment_failed",
			"name_en" => "Payment not made",
			"name_cs" => "Platba nebyla uskutečněna",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 50,
			//
			"finishing_unsuccessfully" => true,
		];

		$values_ar[] = [
			"id" => 6,
			"code" => "processing",
			"name_en" => "Order processing started",
			"name_cs" => "Zahájeno zpracování objednávky",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 60,
		];

		$values_ar[] = [
			"id" => 8,
			"code" => "ready_for_pickup",
			"name_en" => "Ready for pickup",
			"name_cs" => "Připraveno k vyzvednutí na odběrném místě",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockount" => false,
			"rank"  => 65,
			//
			"finishing_successfully" => true,
		];

		$values_ar[] = [
			"id" => 7,
			"code" => "shipped",
			"name_en" => "Shipped",
			"name_cs" => "Předáno dopravci",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => true,
			"rank"  => 70,
			//
			"finished_successfully" => true,
		];

		$values_ar[] = [
			"id" => 9,
			"code" => "delivered",
			"name_en" => "Delivered",
			"name_cs" => "Doručeno",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => true,
			"rank"  => 90,
			//
			"finished_successfully" => true,
		];

		$values_ar[] = [
			"id" => 12,
			"code" => "finished_successfully",
			"name_en" => "Finished successfully",
			"name_cs" => "Úspěšně dokončeno",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => true,
			"rank"  => 95,
			//
			"finished_successfully" => true,
		];

		$values_ar[] = [
			"id" => 10,
			"code" => "cancelled",
			"name_en" => "Cancelled",
			"name_cs" => "Zrušeno",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => false,
			"rank"  => 100,
			//
			"finished_unsuccessfully" => true,
		];

		$values_ar[] = [
			"id" => 11,
			"code" => "returned",
			"name_en" => "Order was returned",
			"name_cs" => "Objednávka byla vrácena",
			"notification_enabled" => true,
			"blocking_stockcount" => false,
			"reduce_stockount" => false,
			"rank"  => 110,
			//
			"finished_unsuccessfully" => true,
		];

		$existing = OrderStatus::GetInstanceById($this->dbmole->selectIntoAssociativeArray("SELECT code,id FROM order_statuses"));
		foreach($values_ar as $values){
			$code = $values["code"];
			if(isset($existing[$code])){
				unset($values["id"]);
				$existing[$code]->s($values);
				unset($existing[$code]);
				continue;
			}
			OrderStatus::CreateNewRecord($values);
		}

		myAssert(sizeof($existing)==0);

		$this->dbmole->doQuery("DELETE FROM order_status_allowed_next_order_statuses");

		$next_order_statuses = [
			"new" => [
				"processing",
				"payment_accepted",
				"cancelled"
			],
			"waiting_for_bank_transfer" => [
				"payment_accepted",
				"repeated_payment_request",
				"payment_failed",
				"cancelled",
			],
			"repeated_payment_request" => [
				"payment_accepted",
				"payment_failed",
				"cancelled",
			],
			"payment_accepted" => [
				"processing",
				"shipped",
				"ready_for_pickup",
				"finished_successfully",
				"cancelled",
			],
			"payment_failed" => [
				"waiting_for_bank_transfer",
				"waiting_for_online_payment",
				"processing",
				"cancelled",
			],
			"processing" => [
				"payment_accepted",
				"shipped",
				"ready_for_pickup",
				"finished_successfully",
				"cancelled"
			],
			"shipped" => [
				"delivered",
				"returned",
				"cancelled",
			],
			"ready_for_pickup" => [
				"delivered",
				"returned",
				"cancelled",
			],
			"delivered" => [
				"returned",
			],
			"finished_successfully" => [
				"processing",
				"returned",
				"cancelled",
			],
			"returned" => [
				"processing",
				"cancelled",
			],
			"cancelled" => [
				"processing"
			],
		];
		foreach($next_order_statuses as $code => $next_codes){
			$os = OrderStatus::GetInstanceByCode($code);
			$finder = $os->getAllowedNextOrderStatusesLister();
			foreach($next_codes as $next_code){
				$finder->append(OrderStatus::GetInstanceByCode($next_code));
			}
		}
	}
}
