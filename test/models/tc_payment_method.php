<?php
/**
 *
 * @fixture payment_methods
 */
class TcPaymentMethod extends TcBase {

	function test(){
		$cod = $this->payment_methods["cash_on_delivery"];

		$this->assertEquals(79.0,$cod->getPriceInclVat());
		$this->assertEquals(65.289256,$cod->getPrice());
		$this->assertEquals(21.0,$cod->getVatPercent());
	}
}
