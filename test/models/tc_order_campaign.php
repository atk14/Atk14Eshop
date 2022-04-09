<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 * @fixture delivery_methods
 * @fixture payment_methods
 */
class TcOrderCampaign extends TcBase {

	function test(){
		$campaign_free_shipping = Campaign::CreateNewRecord([
			"free_shipping" => true,
			"minimal_items_price_incl_vat" => 0.0,
			"regions" => '{"CR": true, "SK": true, "EU": true}'
		]);
		$campaign_20_percent_off = Campaign::CreateNewRecord([
			"discount_percent" => 20,
			"minimal_items_price_incl_vat" => 0.0,
			"regions" => '{"CR": true, "SK": true, "EU": true}',
		]);
		$basket = $this->_prepareEmptyBasket();
		$basket->setProductAmount($this->products["wooden_button"],2); // vat_percent: 21%
		$basket->setProductAmount($this->products["book"],1); // vat_percent: 10%

		$order = $basket->createOrder();
		$campaigns = $order->getCampaigns();

		$this->assertEquals(2,sizeof($campaigns));

		$this->assertEquals(121.0,$campaigns[1]->getDiscountAmount());
		$this->assertEquals(100.0,$campaigns[1]->getDiscountAmount(false));
		$this->assertEquals(21.0,$campaigns[1]->getVatPercent());

		$this->assertEquals(65.48,$campaigns[0]->getDiscountAmount());
		$this->assertEquals(58.73,$campaigns[0]->getDiscountAmount(false)); // used averaged items VAT percent
		$this->assertEquals(null,$campaigns[0]->getVatPercent());
	}
}
