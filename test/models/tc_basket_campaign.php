<?php
/**
 *
 * @fixture campaigns
 * @fixture regions
 * @fixture users
 * @fixture currency_rates
 */
class TcBasketCampaign extends TcBase {
	
	function test(){
		$basket = Basket::CreateNewRecord4UserAndRegion($this->users["kveta"],$this->regions["czechoslovakia"]);
		$this->assertEquals("CZK",$basket->getCurrency()->getCode());
		$bc = new BasketCampaign($basket,$this->campaigns["free_shipping"]);
		$this->assertEquals(2000,$bc->getMinimalItemsPriceInclVat()); // CZK

		$basket = Basket::CreateNewRecord4UserAndRegion($this->users["kveta"],$this->regions["SK"]);
		$this->assertEquals("EUR",$basket->getCurrency()->getCode());
		$bc = new BasketCampaign($basket,$this->campaigns["free_shipping"]);
		$this->assertEquals(76.92,$bc->getMinimalItemsPriceInclVat()); // EUR
	}
}
