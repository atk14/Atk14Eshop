<?php
trait TraitPriceManipulation {

	function _removeVat($price,$vat_percent,$keep_vat = false){
		if(is_null($price) || is_null($vat_percent) || $keep_vat){ return $price; }
		$price = ($price / (100.0 + $vat_percent)) * 100;
		return $this->_roundInternal($price);
	}

	function _addVat($price,$vat_percent,$incl_vat = true){
		if(is_null($price) || is_null($vat_percent) || !$incl_vat){ return $price; }
		$price = $price * (1.0 + $vat_percent / 100.0);
		return $this->_roundInternal($price);
	}

	function _roundInternal($price){
		if(is_null($price)){ return $price; }
		return round($price,INTERNAL_PRICE_DECIMALS);
	}
}
