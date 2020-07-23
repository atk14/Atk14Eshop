<?php
/**
 * @fixture delivery_services
 */
class TcDeliveryService extends TcBase {

	function test() {
		$this->assertFalse($this->delivery_services["zasilkovna"]->canBeUsed());
		$this->assertTrue($this->delivery_services["posta"]->canBeUsed());
	}
}
