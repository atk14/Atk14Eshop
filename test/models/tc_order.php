<?php
/**
 *
 * @fixture orders
 * @fixture delivery_methods
 * @fixture delivery_service_branches
 * @fixture payment_transactions
 */
class TcOrder extends TcBase {

	function test_OrderStatuses(){
		$order = $this->orders["test"];

		$current_status = $order->getOrderStatus();
		$this->assertEquals("new",$current_status->getCode());

		$history_items = $order->getOrderHistory();
		$this->assertEquals(1,sizeof($history_items));
		$this->assertEquals("new",$history_items[0]->getOrderStatus()->getCode());

		$this->assertEquals(null,$order->getPreviousOrderStatus());

		$order->setNewOrderStatus("processing");

		$current_status = $order->getOrderStatus();
		$this->assertEquals("processing",$current_status->getCode());

		$history_items = $order->getOrderHistory();
		$this->assertEquals(2,sizeof($history_items));
		$this->assertEquals("new",$history_items[0]->getOrderStatus()->getCode());
		$this->assertEquals("processing",$history_items[1]->getOrderStatus()->getCode());

		$history_items = $order->getOrderHistory(array("reverse" => true));
		$this->assertEquals(2,sizeof($history_items));
		$this->assertEquals("processing",$history_items[0]->getOrderStatus()->getCode());
		$this->assertEquals("new",$history_items[1]->getOrderStatus()->getCode());

		$previous_status = $order->getPreviousOrderStatus();
		$this->assertEquals("new",$previous_status->getCode());
	}

	function test_isPaid(){
		// Bank transfer - delivered doesn't mean paid

		$order = $this->orders["test_bank_transfer"];
		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("processing");
		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("delivered");
		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("payment_accepted");
		$this->assertEquals(true,$order->isPaid());

		$order->setNewOrderStatus("processing");
		$this->assertEquals(true,$order->isPaid());

		$order->setNewOrderStatus("payment_failed");
		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("processing");
		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("payment_accepted");
		$this->assertEquals(true,$order->isPaid());

		// Cash on delivery - delivered means paid

		$order = $this->orders["test_cash_on_delivery"];

		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("processing");
		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("delivered");
		$this->assertEquals(true,$order->isPaid());

		$order->setNewOrderStatus("processing");
		$this->assertEquals(true,$order->isPaid());

		$order->setNewOrderStatus("payment_failed");
		$this->assertEquals(false,$order->isPaid());

		$order->setNewOrderStatus("payment_accepted");
		$this->assertEquals(true,$order->isPaid());
	}

	function test_canBeFulfilled(){
		$order = $this->orders["test_bank_transfer"];
		$this->assertEquals(false,$order->canBeFulfilled());

		$order->setNewOrderStatus("processing");
		$this->assertEquals(false,$order->canBeFulfilled());

		$order->s("price_to_pay",0.0);
		$this->assertEquals(true,$order->canBeFulfilled());

		$order->s("price_to_pay",123.0);
		$this->assertEquals(false,$order->canBeFulfilled());

		$order->setNewOrderStatus("payment_accepted");
		$this->assertEquals(true,$order->canBeFulfilled());

		$order->setNewOrderStatus("shipped");
		$this->assertEquals(true,$order->canBeFulfilled());

		$order->setNewOrderStatus("cancelled");
		$this->assertEquals(false,$order->canBeFulfilled());

		// cash on delivery
	
		$order = $this->orders["test_cash_on_delivery"];
		$this->assertEquals(false,$order->canBeFulfilled());

		$order->setNewOrderStatus("shipped");
		$this->assertEquals(false,$order->canBeFulfilled());

		$order->setNewOrderStatus("delivered");
		$this->assertEquals(true,$order->canBeFulfilled());

		$order->setNewOrderStatus("finished_successfully");
		$this->assertEquals(true,$order->canBeFulfilled());

		$order->setNewOrderStatus("cancelled");
		$this->assertEquals(false,$order->canBeFulfilled());
	}

	function test_getAllowedNextOrderStatuses(){
		$order = $this->orders["test_bank_transfer"]; // "new"

		$order->setNewOrderStatus("waiting_for_bank_transfer");
		$statuses = $order->getAllowedNextOrderStatuses();
		$statuses = $this->_statuses_to_codes($statuses);
		$this->assertEquals(["payment_accepted","repeated_payment_request","payment_failed","processing","cancelled"],$statuses);

		$order->setNewOrderStatus("payment_accepted");
		$statuses = $order->getAllowedNextOrderStatuses();
		$statuses = $this->_statuses_to_codes($statuses);
		$this->assertEquals(["processing","shipped","ready_for_pickup","finished_successfully","cancelled"],$statuses);

		$order->setNewOrderStatus("processing");
		$statuses = $order->getAllowedNextOrderStatuses();
		$statuses = $this->_statuses_to_codes($statuses);
		$this->assertEquals(["payment_accepted","shipped","ready_for_pickup","finished_successfully","cancelled"],$statuses);
	}

	function _statuses_to_codes($statuses){
		return array_map(function($status){ return $status->getCode(); },$statuses);
	}

	function test_getPhones(){
		$order = $this->orders["test"];

		$this->assertEquals(["+420.605111222","+420.605333444"],$order->getPhones());

		$order->s("delivery_phone",null);
		$this->assertEquals(["+420.605111222"],$order->getPhones());

		$order->s("phone","");
		$this->assertEquals([],$order->getPhones());

		$order->s([
			"phone" => "+420.605333444",
			"delivery_phone" => "+420.605333444"
		]);
		$this->assertEquals(["+420.605333444"],$order->getPhones());
	}

	function test_getDeliveryMethodData(){
		$order = $this->orders["test"];

		$this->assertNull($order->getDeliveryMethodData());
		$this->assertNull($order->getDeliveryMethodData(["as_json" => false]));
		$this->assertNull($order->getDeliveryMethodData(["as_json" => true]));
		$this->assertNull($order->getDeliveryMethodData(false));
		$this->assertNull($order->getDeliveryMethodData(true));

		$order->s([
			"delivery_method_id" => $this->delivery_methods["zasilkovna"],
			"delivery_method_data" => $this->delivery_service_branches["zasilkovna_1"]->getDeliveryMethodData(["as_json" => true]),
		]);
		//
		$dm_data = $order->getDeliveryMethodData();
		$this->assertNotNull($dm_data);
		$this->assertEquals("První pražská Zásilkovna",$dm_data["delivery_address"]["place"]);
		//
		$dm_data = $order->getDeliveryMethodData(["as_json" => false]);
		$this->assertNotNull($dm_data);
		$this->assertEquals("První pražská Zásilkovna",$dm_data["delivery_address"]["place"]);
		//
		$dm_data = $order->getDeliveryMethodData(false);
		$this->assertNotNull($dm_data);
		$this->assertEquals("První pražská Zásilkovna",$dm_data["delivery_address"]["place"]);
		//
		$dm_data_json = $order->getDeliveryMethodData(["as_json" => true]);
		$this->assertTrue(is_string($dm_data_json));
		$this->assertTrue(!!preg_match('/{/',$dm_data_json));
		//
		$dm_data_json = $order->getDeliveryMethodData(true);
		$this->assertTrue(is_string($dm_data_json));
		$this->assertTrue(!!preg_match('/{/',$dm_data_json));

		// setting data for another method has no effect on Order::getDeliveryMethodData()
		$order->s([
			"delivery_method_data" => $this->delivery_service_branches["posta_12000"]->getDeliveryMethodData(["as_json" => true]),
		]);
		//
		$dm_data = $order->getDeliveryMethodData();
		$this->assertNotNull($dm_data);
		$this->assertEquals("Praha 2",$dm_data["delivery_address"]["place"]);
	}

	function test_increasePricePaid(){
		$dbmole = Order::GetDbmole();

		$order = $this->orders["test"];
		$this->assertTrue(null === $order->getPricePaid());

		$order->increasePricePaid(null);
		$this->assertTrue(0.0 === $order->getPricePaid());

		$order->increasePricePaid(10.25);
		$this->assertTrue(10.25 === $order->getPricePaid());

		$order->increasePricePaid(12.33);
		$this->assertTrue(22.58 === $order->getPricePaid());

		$this->assertEquals(1,$dbmole->getAffectedRows());

		// we need to be sure, that Order::increasePricePaid() affects just one record
		$order = Order::GetInstanceById($this->orders["test_bank_transfer"]->getId(),["use_cache" => false]);
		$this->assertEquals(null,$order->getPricePaid());
	}

	function test_getPaymentTransaction(){
		$order = $this->orders["test"];

		$this->assertEquals(null,$order->getPaymentTransaction());

		//

		$order = $this->orders["test_credit_card"];

		$pt = $order->getPaymentTransaction();
		$this->assertEquals($this->payment_transactions["test_credit_card_2"]->getId(),$pt->getId());

		$this->payment_transactions["test_credit_card_1"]->s([
			"payment_status_id" => PaymentStatus::GetInstanceByCode("paid"),
		]);

		$pt = $order->getPaymentTransaction();
		$this->assertEquals($this->payment_transactions["test_credit_card_1"]->getId(),$pt->getId());
	}
}
