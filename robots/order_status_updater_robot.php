<?php
class OrderStatusUpdaterRobot extends ApplicationRobot {

	function run(){
		$robot = User::FindById(User::ID_ROBOT);
		$now = now();
		$created_at_min = Date::ByDate($now)->minusDays(30)->toString();

		$codes = [
			"repeated_payment_request",
			"repeated_call_for_pickup_order",
		];
		$cancelled = OrderStatus::GetInstanceByCode("cancelled");

		// repeated_payment_request or repeated_call_for_pickup_order -> after ~ 10 days -> cancelled
		$orders = Order::FindAll([
			"conditions" => [
				"created_at>:created_at_min",
				"order_status_id IN (SELECT id FROM order_statuses WHERE code IN :codes)",
				"DATE_TRUNC('day',order_status_set_at) + INTERVAL '11 days'<=:now"
			],
			"bind_ar" => [
				":created_at_min" => $created_at_min,
				":codes" => $codes,
				":now" => now(),
			]
		]);
		foreach($orders as $order){
			$this->dbmole->begin();
			$current_order_status = $order->getOrderStatus()->getCode();
			$order->setNewOrderStatus([
				"order_status_id" => $cancelled,
				"order_status_set_by_user_id" => $robot,
			]);
			$this->dbmole->commit();
			$this->logger->info(sprintf("order status updated on order %s (Order#%s) from $current_order_status to cancelled",$order->getOrderNo(),$order->getId()));
		}
	}
}
