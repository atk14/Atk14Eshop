<?php
class OrderVoucher extends BasketOrOrderVoucher {
	
	function setRank($rank){
		$this->_setRank($rank,[
			"order_id" => $this->getOrderId(),
		]);
	}

	function getOrder(){
		return Cache::Get("Order",$this->getOrderId());
	}

	function createdAdministratively(){
		return $this->g("created_administratively");
	}

	function getCreatedByUser(){
		return Cache::Get("User",$this->getCreatedByUserId());
	}

	function getVatPercent(){
		return $this->g("vat_percent");
	}

}
