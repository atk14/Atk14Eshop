<?php
class Zz02AddingOrderStatusRepeatedCallForPickupOrderMigration extends ApplicationMigration {

	function up(){
		$os = OrderStatus::CreateNewRecord([
			"id" => 14,
			"code" => "repeated_call_for_pickup_order",
			"name_en" => "Repeated call for pickup order",
			"name_cs" => "Opakovaná výzva k vyzvednutí na odběrném místě",
			"notification_enabled" => true,
			"blocking_stockcount" => true,
			"reduce_stockcount" => false,
			"rank"  => 67,
			//
			"finishing_successfully" => true,
		]);

		$this->_appendNextOrderStatuses("repeated_call_for_pickup_order",[
			"delivered",
			"returned",
			"cancelled",
		]);

		$this->_appendNextOrderStatuses("ready_for_pickup",[
			"repeated_call_for_pickup_order",
		]);
	}
}
