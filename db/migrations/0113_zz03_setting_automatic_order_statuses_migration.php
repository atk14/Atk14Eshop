<?php
class Zz03SettingAutomaticOrderStatusesMigration extends ApplicationMigration {

	function up(){
		$table = [
			"repeated_payment_request" => ["cancelled", 11],
			"repeated_call_for_pickup_order" => ["cancelled", 11],
		];

		foreach($table as $order_status => $next_automatic_order_status_ar){
			list($next_automatic_order_status,$days) = $next_automatic_order_status_ar;

			$order_status = OrderStatus::GetInstanceByCode($order_status);
			$next_automatic_order_status = OrderStatus::GetInstanceByCode($next_automatic_order_status);

			if(!$order_status || !$next_automatic_order_status){ continue; }

			$order_status->s([
				"next_automatic_order_status_id" => $next_automatic_order_status,
				"next_automatic_order_status_after_days" => $days,

				"updated_at" => $order_status->g("updated_at"),
				"updated_by_user_id" => $order_status->g("updated_by_user_id"),
			]);
		}
	}
}
