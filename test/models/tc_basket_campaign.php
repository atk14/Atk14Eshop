<?php
/**
 *
 * @fixture campaigns
 * @fixture regions
 * @fixture users
 * @fixture currency_rates
 * @fixture products
 * @fixture pricelist_items
 */
class TcBasketCampaign extends TcBase {

	function test_getMinimalItemsPriceInclVat(){
		$basket = Basket::CreateNewRecord4UserAndRegion($this->users["kveta"],$this->regions["czechoslovakia"]);
		$this->assertEquals("CZK",$basket->getCurrency()->getCode());
		$bc = new BasketCampaign($basket,$this->campaigns["free_shipping"]);
		$this->assertEquals(2000,$bc->getMinimalItemsPriceInclVat()); // CZK

		$basket = Basket::CreateNewRecord4UserAndRegion($this->users["kveta"],$this->regions["SK"]);
		$this->assertEquals("EUR",$basket->getCurrency()->getCode());
		$bc = new BasketCampaign($basket,$this->campaigns["free_shipping"]);
		$this->assertEquals(76.92,$bc->getMinimalItemsPriceInclVat()); // EUR
	}

	function test(){
		$basket = Basket::CreateNewRecord4UserAndRegion($this->users["kveta"],$this->regions["czechoslovakia"]);
		$this->assertEquals(0,sizeof($basket->getCampaigns()));

		//

		$basket->setProductAmount($this->products["black_tea"],1); // 22.99 CKZ incl. VAT
		$basket_campaigns = $basket->getBasketCampaigns();
		$this->assertEquals(0,sizeof($basket_campaigns));

		//

		$basket->setProductAmount($this->products["black_tea"],44); // 1011.56 CKZ incl. VAT
		$basket_campaigns = $basket->getBasketCampaigns();
		$this->assertEquals(1,sizeof($basket_campaigns));

		//

		$basket->setProductAmount($this->products["fridge"],1); // 11999 CZK incl. VAT
		$basket_campaigns = $basket->getBasketCampaigns();
		$this->assertEquals(3,sizeof($basket_campaigns));

		$this->assertEquals($this->campaigns["gift"]->getId(),$basket_campaigns[0]->getCampaignId());
		$this->assertEquals(6,$basket_campaigns[0]->getGiftAmount()); // (1011.56 + 11999) / 2000 = 6.5

		$this->assertEquals($this->campaigns["registration_discount"]->getId(),$basket_campaigns[1]->getCampaignId());

		$this->assertEquals($this->campaigns["free_shipping"]->getId(),$basket_campaigns[2]->getCampaignId());
	}
}
