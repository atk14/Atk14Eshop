<?php
/**
 *
 * @fixture orders
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

		$order->setNewOrderStatus("payment_accepted");
		$this->assertEquals(true,$order->canBeFulfilled());

		$order->setNewOrderStatus("cancelled");
		$this->assertEquals(false,$order->canBeFulfilled());
	}

	function test_getAllowedNextOrderStatuses(){
		$order = $this->orders["test_bank_transfer"]; // "new"

		$order->setNewOrderStatus("waiting_for_bank_transfer");
		$statuses = $order->getAllowedNextOrderStatuses();
		$statuses = $this->_statuses_to_codes($statuses);
		$this->assertEquals(["payment_accepted","payment_failed","cancelled"],$statuses);

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
}
