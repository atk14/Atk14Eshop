<?php
class BasketOrOrderVoucher extends ApplicationModel implements Rankable {

	// Pro implementaci Rankable
	function setRank($rank){
		$class = get_class($this);
		throw new Exception("$class::setRank() has to be redefined");
	}

	function getVoucher(){
		return Cache::Get("Voucher",$this->getVoucherId());
	}

	function getVoucherCode(){
		return $this->getVoucher()->getVoucherCode();
	}

	function getDiscountPercent(){
		return $this->getVoucher()->getDiscountPercent();
	}

	function freeShipping(){
		return $this->getVoucher()->freeShipping();
	}

	function getDescription(){
		$description = $this->getVoucher()->getDescription();
		if(strlen((string)$description)){
			return $description;
		}
		if($this->getDiscountPercent()>0.0 || $this->getDiscountAmount()){
			return _("Slevový kupón");
		}
		if($this->freeShipping()){
			return _("Doprava zdarma");
		}
		return _("Dárkový poukaz");
	}

	function getIconSymbol(){
		if($this->getDiscountPercent()>0.0 || $this->getDiscountAmount()){
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
