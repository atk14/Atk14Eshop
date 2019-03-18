<?php
class OrderVoucher extends ApplicationModel implements Rankable {
	
	function setRank($rank){
		$this->_setRank($rank,[
			"order_id" => $this->getOrderId(),
		]);
	}

	function getVoucher(){
		return Cache::Get("Voucher",$this->g("voucher_id"));
	}

	function getVoucherCode(){
		return $this->getVoucher()->getVoucherCode();
	}

	function createdAdministratively(){
		return $this->g("created_administratively");
	}

	function getCreatedByUser(){
		return Cache::Get("User",$this->getCreatedByUserId());
	}

	function toString(){
		return $this->getVoucherCode();
	}
}
