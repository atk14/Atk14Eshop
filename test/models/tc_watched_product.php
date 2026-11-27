<?php
/**
 *
 * @fixture products
 * @fixture warehouses
 * @fixture warehouse_items
 * @fixture watched_products
 */
class TcWatchedProduct extends TcBase {

	function _tearDown(){
		parent::_tearDown();
		WatchedProduct::$NOTIFICATION_DELAY_MINUTES = 0;
		WatchedProduct::$NOTIFICATION_STAGGER_MINUTES = 0;
		WatchedProduct::$NOTIFICATION_STAGGER_LIMIT = 0;
	}

	function test(){
		$warehouse = Warehouse::GetDefaultInstance4Eshop();

		WatchedProduct::ScheduleNotifications();
		$watched_products = WatchedProduct::GetWatchedProductsToNotify();
		$this->assertEquals(0,sizeof($watched_products));

		$warehouse->addProduct($this->products["fridge"],2);

		// product is not visible
		$this->products["fridge"]->s("visible",false);
		WatchedProduct::ScheduleNotifications();
		$watched_products = WatchedProduct::GetWatchedProductsToNotify();
		$this->assertEquals(0,sizeof($watched_products));

		// visible product
		$this->products["fridge"]->s("visible",true);
		WatchedProduct::ScheduleNotifications();
		$watched_products = WatchedProduct::GetWatchedProductsToNotify();
		$this->assertEquals(2,sizeof($watched_products));
	}

	function test_delay_postpones_notification_and_gets_cancelled_when_product_goes_out_of_stock_again(){
		WatchedProduct::$NOTIFICATION_DELAY_MINUTES = 120;

		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		$warehouse->addProduct($this->products["fridge"],2);

		WatchedProduct::ScheduleNotifications();

		// notify_at has been scheduled, but 2 hours in the future, so nobody is to be notified yet
		$this->assertEquals(0,sizeof(WatchedProduct::GetWatchedProductsToNotify()));

		$fridge_1 = WatchedProduct::FindFirst("email","john@doe.com");
		$this->assertNotNull($fridge_1->g("notify_at"));
		$this->assertTrue($fridge_1->g("notify_at")>now());

		// the product gets moved out of the eshop warehouse again before the delay elapses
		$warehouse->addProduct($this->products["fridge"],-2);
		WatchedProduct::CancelStaleSchedules();

		$fridge_1 = WatchedProduct::FindFirst("email","john@doe.com");
		$this->assertNull($fridge_1->g("notify_at"));
		$this->assertFalse($fridge_1->notified()); // watching stays enabled, nothing was sent
	}

	function test_stagger_notifies_watchers_in_order_they_were_created(){
		WatchedProduct::$NOTIFICATION_STAGGER_MINUTES = 10;

		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		$warehouse->addProduct($this->products["fridge"],10);

		WatchedProduct::ScheduleNotifications();

		// only the first-created watcher (fridge_1) is due right away, fridge_2 has to wait 10 minutes
		$to_notify = WatchedProduct::GetWatchedProductsToNotify();
		$this->assertEquals(1,sizeof($to_notify));
		$this->assertEquals("john@doe.com",$to_notify[0]->getEmail());

		$fridge_1 = WatchedProduct::FindFirst("email","john@doe.com");
		$fridge_2 = WatchedProduct::FindFirst("email","samantha@doe.com");
		$this->assertTrue($fridge_2->g("notify_at")>$fridge_1->g("notify_at"));
	}

	function test_stagger_limit_notifies_remaining_watchers_all_at_once(){
		WatchedProduct::$NOTIFICATION_STAGGER_MINUTES = 10;
		WatchedProduct::$NOTIFICATION_STAGGER_LIMIT = 2; // fridge_1 (1st), fridge_2 (2nd) staggered, 3rd+ together with the 2nd

		$third_watcher = WatchedProduct::CreateNewRecord([
			"product_id" => $this->products["fridge"],
			"email" => "third@doe.com",
		]);

		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		$warehouse->addProduct($this->products["fridge"],10);

		WatchedProduct::ScheduleNotifications();

		$fridge_1 = WatchedProduct::FindFirst("email","john@doe.com");
		$fridge_2 = WatchedProduct::FindFirst("email","samantha@doe.com");
		$third_watcher = WatchedProduct::FindFirst("email","third@doe.com");

		$this->assertTrue($fridge_2->g("notify_at")>$fridge_1->g("notify_at"));
		$this->assertEquals($fridge_2->g("notify_at"),$third_watcher->g("notify_at"));
	}

	function test_already_sold_out_right_after_first_notification_keeps_watching_enabled_for_the_rest(){
		WatchedProduct::$NOTIFICATION_STAGGER_MINUTES = 10;

		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		$warehouse->addProduct($this->products["fridge"],10);

		WatchedProduct::ScheduleNotifications();

		$fridge_1 = WatchedProduct::FindFirst("email","john@doe.com");
		$fridge_1->markAsNotified();

		// product gets sold out before fridge_2's staggered notify_at arrives
		$warehouse->addProduct($this->products["fridge"],-10);
		WatchedProduct::CancelStaleSchedules();

		$fridge_2 = WatchedProduct::FindFirst("email","samantha@doe.com");
		$this->assertNull($fridge_2->g("notify_at"));
		$this->assertFalse($fridge_2->notified()); // watching stays enabled
	}
}
