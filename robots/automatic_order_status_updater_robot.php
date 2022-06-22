<?php
class AutomaticOrderStatusUpdaterRobot extends ApplicationRobot {

	function run(){
		$robot = User::FindById(User::ID_ROBOT);
		$now = now();
		$created_at_min = Date::ByDate($now)->minusDays(30)->toString();
		$order_statuses = OrderStatus::FindAll("next_automatic_order_status_id IS NOT NULL");

		foreach($order_statuses as $order_status){	
			$orders = Order::FindAll([
				"conditions" => [
					"created_at>:created_at_min",
					"order_status_id=:order_status",
					"order_status_set_at + INTERVAL :days<=:now"
				],
				"bind_ar" => [
					":created_at_min" => $created_at_min,
					":order_status" => $order_status,
					":days" => sprintf("%d days",$order_status->getNextAutomaticOrderStatusAfterDays()),
					":now" => now(),
				],
				"order_by" => "order_status_set_at, created_at, id",
			]);
			foreach($orders as $order){
				$this->dbmole->begin();
				$current_order_status = $order->getOrderStatus();
				$next_automatic_order_status = $order_status->getNextAutomaticOrderStatus();
				$order->setNewOrderStatus([
					"order_status_id" => $next_automatic_order_status,
					"order_status_set_by_user_id" => $robot,
				]);
				$this->dbmole->commit();
				$this->logger->info(sprintf("order status automatically updated on order %s (Order#%s) from %s to %s",$order->getOrderNo(),$order->getId(),$current_order_status->getCode(),$next_automatic_order_status->getCode()));
			}
		}
	}
}
