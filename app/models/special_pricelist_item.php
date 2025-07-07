<?php
class SpecialPricelistItem extends ApplicationModel {

	use TraitPriceManipulation;

	function getSpecialPricelist(){
		return Cache::Get("SpecialPricelist",$this->getSpecialPricelistId());
	}

	function containsPriceWithoutVat(){
		return $this->getSpecialPricelist()->containsPricesWithoutVat();
	}

	function containsEndPrice(){
		return !$this->containsPricesWithoutVat();
	}

	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
	}

	function getVatPercent(){
		return $this->getProduct()->getVatPercent();
	}

	function getPrice($incl_vat = false){
		if($incl_vat){
			return $this->getPriceInclVat();
		}
	
		$price = $this->g("price");
		if(!$this->containsPriceWithoutVat()){
			$price = $this->_removeVat($price,$this->getVatPercent());
		}
		return $price;
	}

	function getPriceInclVat(){
		$price = $this->g("price");
		if($this->containsPriceWithoutVat()){
			$price = $this->_addVat($price,$this->getVatPercent());
		}
		return $price;
	}

}
