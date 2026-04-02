<?php
class BasketCampaign {

	protected $basket;
	protected $campaign;

	function __construct($basket,$campaign){
		$this->basket = $basket;
		$this->campaign = $campaign;
	}

	function getBasket(){
		return $this->basket;
	}

	function getCampaign(){
		return $this->campaign;
	}

	function getCampaignId(){
		return $this->getCampaign()->getId();
	}
	
	function getName(){
		return $this->getCampaign()->getName();
	}

	function freeShipping(){
		return $this->getCampaign()->freeShipping();
	}

	function getDiscountPercent(){
		return $this->getCampaign()->getDiscountPercent();
	}

	function getGiftProduct(){
		return $this->getCampaign()->getGiftProduct();
	}

	function getGiftAmount(){
		$gift_amount = $this->getCampaign()->getGiftAmount();
		$gift_multiply = $this->getCampaign()->getGiftMultiply();
		if($gift_multiply){
			$miminimal_items_price_incl_vat = $this->getMinimalItemsPriceInclVat();
			$items_price = $this->basket->getItemsPriceInclVat();
			$multiplier = floor($items_price / $miminimal_items_price_incl_vat);
			$gift_amount = $multiplier * $gift_amount;
		}
		return $gift_amount;
	}

	function getMinimalItemsPriceInclVat(){
		$basket = $this->getBasket();
		$campaign = $this->getCampaign();
		$currency = $this->getBasket()->getCurrency();
		$minimal_items_price_incl_vat = $campaign->getMinimalItemsPriceInclVat() / $currency->getRate();
		$minimal_items_price_incl_vat = $currency->roundPrice($minimal_items_price_incl_vat);
		return $minimal_items_price_incl_vat;
	}

	function getDiscountAmount($incl_vat = true){
		$discount_percent = ApplicationHelpers::GetPercentageDiscountApplicableOnBasket($this);
		if($discount_percent<=0.0){ return 0.0; }

		$out = 0.0;
		foreach($this->basket->getItems() as $item){
			$product = $item->getProduct();
			if(!$product->invoiceDiscountAllowed()){ continue; }

			$p_price = $item->getProductPrice();

			if($p_price->discounted()){
				// Procentni slevu nelze uplatnit na jiz slevnene zbozi
				continue;
			}

			$current_price = $p_price->getPrice($incl_vat);
			$campaign_price = ($current_price / 100.0) * (100.0 - $discount_percent);
			$out += $current_price - $campaign_price;
		}

		$currency = $this->basket->getCurrency();
		$out = $currency->roundPrice($out);

		return $out;
	}

	function toArray(){
		return [
			"campaign" => $this->getCampaign()->toArray(),
			"basket" => $this->getBasket()->toArray(),
		];
	}

}
