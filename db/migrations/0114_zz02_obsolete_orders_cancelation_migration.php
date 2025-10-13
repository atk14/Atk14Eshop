<?php
class Zz02ObsoleteOrdersCancelationMigration extends ApplicationMigration {

	function up(){
		$robot = User::GetRobot();
		$cancelled = OrderStatus::GetInstanceByCode("cancelled");

		$order_statuses = OrderStatus::FindAll("next_automatic_order_status_id IS NOT NULL");

		foreach($order_statuses as $order_status){
			foreach(Order::FindAll("order_status_id=:order_status AND order_status_set_at<NOW() - INTERVAL '20 days'",[":order_status" => $order_status],["order_by" => "order_status_set_at"]) as $order){
				$this->logger->info(sprintf("Status updated on Order#%s, order_no=%s: %s -> cancelled",$order->getId(),$order->getOrderNo(),$order->getOrderStatus()->getCode()));
				$order->setNewOrderStatus([
					"order_status_id" => $cancelled,
					"order_status_set_by_user_id" => $robot,
				],[
					"disable_notification" => true,
				]);
			}
		}
	}
}
