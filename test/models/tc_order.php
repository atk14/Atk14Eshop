<?php
/**
 *
 * @fixture orders
 */
class TcOrder extends TcBase {

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
