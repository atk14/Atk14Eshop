<?php
/**
 *
 * @fixture pricelist_items
 */
class TcPricelistItem extends TcBase {

	function test(){
		$pi = $this->pricelist_items["mint_tea"];

		$this->assertEquals(21.0,$pi->getVatPercent());

		$this->assertEquals(20.0,$pi->getPrice());
		$this->assertEquals(24.2,$pi->getPriceInclVat());
		$this->assertEquals(24.2,$pi->getPrice(true));
		$this->assertEquals(20.0,$pi->getPrice(false));
	}
}
