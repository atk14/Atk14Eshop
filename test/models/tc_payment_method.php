<?php
/**
 *
 * @fixture payment_methods
 */
class TcPaymentMethod extends TcBase {

	function test(){
		$cod = $this->payment_methods["cash_on_delivery"];

		$this->assertEquals(79.0,$cod->getPriceInclVat());
		$this->assertEquals(75.238095,$cod->getPrice());
		$this->assertEquals(5.0,$cod->getVatPercent());
	}

	function test_isOnlineMethod(){
		$pm = PaymentMethod::CreateNewRecord([
		]);
		$this->assertEquals(false,$pm->isOnlineMethod());

		$pg = PaymentGateway::CreateNewRecord([
			"id" => 100,
			"code" => "testing"
		]);
		$pm->s("payment_gateway_id",$pg);
		$this->assertEquals(true,$pm->isOnlineMethod());
	}

	function test_getPaymentGatewayConfig(){
		$this->assertEquals(["payment_method" => "card"],$this->payment_methods["credit_card"]->getPaymentGatewayConfig());
		$this->assertEquals([],$this->payment_methods["bank_transfer"]->getPaymentGatewayConfig());
	}
}
