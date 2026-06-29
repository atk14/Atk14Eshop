<?php
/**
 * @fixture delivery_methods
 * @fixture payment_methods
 */
class TcOrderWithdrawalRequest extends TcBase {

	function test(){
		// S cerstvou objednavkou neni problem
		$order = $this->_createOrder([]);
		$order->setNewOrderStatus("finished_successfully");
		$this->assertEquals(true,OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason));

		// Nezpracovana objednavka
		$order = $this->_createOrder([
		]);
		$this->assertEquals(false,OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason));
		$this->assertEquals(_("Objednávka doposud nebyla zpracována."),$reason);

		// Hodne stara objednavka
		$order = $this->_createOrder([
			"created_at" => "2026-05-01",
		]);
		$order->setNewOrderStatus([
			"order_status_id" => OrderStatus::GetInstanceByCode("finished_successfully"),
			"order_status_set_at" => "2026-05-01",
		]);
		$this->assertEquals(false,OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason));
		$this->assertEquals(_("Objednávku již není možné vrátit."),$reason);

		// Osobni vyzvednuti - 14. den to jde
		$today = Date::Today();
		$date = $today->minusDays(14);
		$order = $this->_createOrder([
			"delivery_method_id" => $this->delivery_methods["personal"],
			"created_at" => (string)$date,
		]);
		$order->setNewOrderStatus([
			"order_status_id" => OrderStatus::GetInstanceByCode("finished_successfully"),
			"order_status_set_at" => (string)$date,
		]);
		$order->setNewOrderStatus([
			"order_status_id" => OrderStatus::GetInstanceByCode("delivered"),
			"order_status_set_at" => (string)$date,
		]);
		$this->assertEquals(true,OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason));

		// Osobni vyzvednuti - 15. den to uz nejde
		$today = Date::Today();
		$date = $today->minusDays(15);
		$order = $this->_createOrder([
			"delivery_method_id" => $this->delivery_methods["personal"],
			"created_at" => (string)$date,
		]);
		$order->setNewOrderStatus([
			"order_status_id" => OrderStatus::GetInstanceByCode("finished_successfully"),
			"order_status_set_at" => (string)$date,
		]);
		$order->setNewOrderStatus([
			"order_status_id" => OrderStatus::GetInstanceByCode("delivered"),
			"order_status_set_at" => (string)$date,
		]);
		$this->assertEquals(false,OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason));
		$this->assertEquals(_("Objednávku již není možné vrátit."),$reason);

		// Dpd - 21. den to jde (14 + 7 dni rezerva)
		$today = Date::Today();
		$date = $today->minusDays(21);
		$order = $this->_createOrder([
			"delivery_method_id" => $this->delivery_methods["dpd"],
			"created_at" => (string)$date,
		]);
		$order->setNewOrderStatus([
			"order_status_id" => OrderStatus::GetInstanceByCode("finished_successfully"),
			"order_status_set_at" => (string)$date,
		]);
		$this->assertEquals(true,OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason));

		// Dpd - 22. den to uz nejde
		$today = Date::Today();
		$date = $today->minusDays(22);
		$order = $this->_createOrder([
			"delivery_method_id" => $this->delivery_methods["dpd"],
			"created_at" => (string)$date,
		]);
		$order->setNewOrderStatus([
			"order_status_id" => OrderStatus::GetInstanceByCode("finished_successfully"),
			"order_status_set_at" => (string)$date,
		]);
		$this->assertEquals(false,OrderWithdrawalRequest::CanOrderBeWithdrawn($order,$reason));
		$this->assertEquals(_("Objednávku již není možné vrátit."),$reason);
	}

	function _createOrder($values =  []){
		$delivery = $this->delivery_methods["dpd"];
		$payment = $this->payment_methods["credit_card"];

		$values += [
			"user_id" => null,
			"region_id" => Region::GetDefaultRegion(),
			"delivery_method_id" => $delivery,
			"delivery_fee_incl_vat" => $delivery->getPriceInclVat(),
			"payment_method_id" => $payment,
			"payment_fee_incl_vat" => $payment->getPriceInclVat(),
			"price_to_pay" => 200.0
		];
	
		return Order::CreateNewRecord($values);
	}
}
