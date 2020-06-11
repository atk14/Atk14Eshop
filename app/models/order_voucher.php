<?php
class OrderVoucher extends ApplicationModel implements Rankable {
	
	function setRank($rank){
		$this->_setRank($rank,[
			"order_id" => $this->getOrderId(),
		]);
	}

	function getVoucher(){
		return Cache::Get("Voucher",$this->getVoucherId());
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

	function freeShipping(){
		return $this->getVoucher()->freeShipping();
	}

	function getDescription(){
		$description = $this->getVoucher()->getDescription();
		if(strlen($description)){
			return $description;
		}
		if($this->getDiscountAmount()){
			return _("Slevový kupón");
		}
		if($this->freeShipping()){
			return _("Doprava zdarma");
		}
		return _("Dárkový poukaz");
	}

	function getIconSymbol(){
		if($this->getDiscountAmount()){
			return "percent";
		}
		if($this->freeShipping()){
			return "check";
		}
		return "gift";
	}

	function toString(){
		return $this->getVoucherCode();
	}
}
