<?php
class TcOrderStatus extends TcBase {

	function test(){
		$order_status = OrderStatus::CreateNewRecord([
			"code" => "test",
			"notification_enabled" => true,
			"custom_notification_enabled" => true,
		]);

		$this->assertTrue($order_status->notificationEnabled());
		$this->assertTrue($order_status->notificationEnabled(false));

		$order_status->s("custom_notification_enabled",false);

		$this->assertFalse($order_status->notificationEnabled());
		$this->assertTrue($order_status->notificationEnabled(false));

		$order_status->s([
			"notification_enabled" => false,
			"custom_notification_enabled" => true,
		]);

		$this->assertFalse($order_status->notificationEnabled());
		$this->assertFalse($order_status->notificationEnabled(false));
	}
}
