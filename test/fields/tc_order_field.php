<?php
/**
 *
 * @fixture orders
 */
class TcOrderField extends TcBase {

	function test(){
		$this->field = new OrderField([]);

		$order = $this->orders["test"];
		$o = $this->assertValid($order->getOrderNo());
		$this->assertEquals($order->getId(),$o->getId());

		$err = $this->assertInvalid("XXX");
		$this->assertEquals("Taková objednávka neexistuje",$err);
	}
}
