<?php
class OrderStatusUpdaterRobot extends ApplicationRobot {

	function run(){
		$robot = User::FindById(User::ID_ROBOT);
		$now = now();
		$created_at_min = Date::ByDate($now)->minusDays(30)->toString();

		$repeated_payment_request = OrderStatus::GetInstanceByCode("repeated_payment_request");
		$cancelled = OrderStatus::GetInstanceByCode("cancelled");

		// repeated_payment_request -> after ~ 7 days -> cancelled
		$orders = Order::FindAll([
			"conditions" => [
				"created_at>:created_at_min",
				"order_status_id=:repeated_payment_request",
				"DATE_TRUNC('day',order_status_set_at) + INTERVAL '8 days'<=:now"
			],
			"bind_ar" => [
				":created_at_min" => $created_at_min,
				":repeated_payment_request" => $repeated_payment_request,
				":now" => now(),
			]
		]);
		foreach($orders as $order){
			$this->dbmole->begin();
			$order->setNewOrderStatus([
				"order_status_id" => $cancelled,
				"order_status_set_by_user_id" => $robot,
			]);
			$this->dbmole->commit();
			$this->logger->info(sprintf("order status updated on order %s (Order#%s) from repeated_payment_request to cancelled",$order->getOrderNo(),$order->getId()));
		}
	}
}
