<?php
/**
 *
 * @fixture payment_transactions
 * @fixture payment_methods
 * @fixture delivery_methods
 */
class TcPaymentTransaction extends TcBase {

	function test_getPaymentTransactionUrl(){
		$pt = $this->payment_transactions["test_credit_card_1"];

		$this->assertEquals("https://3dsecure.gpwebpay.com/pgw/order.do?MERCHANTNUMBER=ETC",$pt->getPaymentTransactionUrl());
		$this->assertEquals("https://3dsecure.gpwebpay.com/pgw/order.do?MERCHANTNUMBER=ETC",$pt->getPaymentTransactionUrl(["prefer_external_url" => true]));
		$this->assertNotEquals("https://3dsecure.gpwebpay.com/pgw/order.do?MERCHANTNUMBER=ETC",$pt->getPaymentTransactionUrl(["prefer_external_url" => false]));
	}

	function test_isRepeatable(){
		$order = $this->_create_order([
			"price_to_pay" => 123.0,
		]);
		$pt = PaymentTransaction::CreateNewRecord([
			"order_id" => $order,
			"payment_gateway_id" => 1,
		]);

		$order->setNewOrderStatus("waiting_for_online_payment");
		$this->assertTrue($pt->isRepeatable());

		$order->setNewOrderStatus("payment_failed");
		$this->assertTrue($pt->isRepeatable());

		$order->setNewOrderStatus("cancelled");
		$this->assertFalse($pt->isRepeatable());
	}

	function _create_order($values = []){
		$values += [
			"payment_method_id" => $this->payment_methods["credit_card"],
			"payment_fee_incl_vat" => 0.0,
			"delivery_method_id" => $this->delivery_methods["dpd"],
			"delivery_fee_incl_vat" => 0.0,
			"price_to_pay" => 100.0,
		];
		$order = Order::CreateNewRecord($values,["use_cache" => true]);
		return $order;
	}
}
