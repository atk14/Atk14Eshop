<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 */
class TcPriceFinder extends TcBase {

	function test(){
		$pf = PriceFinder::GetInstance();
		$pf->getPrice($this->products["mint_tea"]);
	}
}
