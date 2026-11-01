<?php
class OrderWithdrawalRequestItem extends ApplicationModel implements Rankable {

	function setRank($rank){
		$this->_setRank($rank);
	}

	function getOrderWithdrawalRequest(){
		return Cache::Get("OrderWithdrawalRequest",$this->getOrderWithdrawalRequestId());
	}

	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
	}
}
