<?php
/**
 *
 * @fixture payment_transactions
 */
class TcPaymentTransaction extends TcBase {

	function test_getPaymentTransactionUrl(){
		$pt = $this->payment_transactions["test_credit_card_1"];

		$this->assertEquals("https://3dsecure.gpwebpay.com/pgw/order.do?MERCHANTNUMBER=ETC",$pt->getPaymentTransactionUrl());
		$this->assertEquals("https://3dsecure.gpwebpay.com/pgw/order.do?MERCHANTNUMBER=ETC",$pt->getPaymentTransactionUrl(["prefer_external_url" => true]));
		$this->assertNotEquals("https://3dsecure.gpwebpay.com/pgw/order.do?MERCHANTNUMBER=ETC",$pt->getPaymentTransactionUrl(["prefer_external_url" => false]));
	}
}
