<?php
class OrderCampaign extends ApplicationModel implements Rankable {

	function setRank($rank){
		$this->_setRank($rank,[
			"order_id" => $this->getOrderId(),
		]);
	}

	function getCampaign(){
		return Cache::Get("Campaign",$this->g("campaign_id"));
	}

	function getDiscountAmount($incl_vat = true){
		$discount_amount = $this->g("discount_amount");
		if(!$incl_vat){
			$currency = $this->getOrder()->getCurrency();
			$vat_percent = $this->getVatPercent();
			if(is_null($vat_percent)){
				$vat_percent = $this->getOrder()->getAveragedItemsVatPercent();
			}
			$discount_amount = 100.0 * ($discount_amount / (100.0 + $vat_percent));
			$discount_amount = $currency->roundPrice($discount_amount);
		}
		return $discount_amount;
	}

	function getName(){
		return $this->getCampaign()->getName();
	}

	function getGiftOrderItem(){
		return Cache::Get("OrderItem",$this->getGiftOrderItemId());
	}

	function createdAdministratively(){
		return $this->g("created_administratively");
	}

	function getCreatedByUser(){
		return Cache::Get("User",$this->getCreatedByUserId());
	}

	function toString(){
		return (string)$this->getName();
	}
}
