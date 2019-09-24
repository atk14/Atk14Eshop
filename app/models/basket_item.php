<?php
definedef("INTERNAL_PRICE_DECIMALS",4);

class BasketItem extends BasketOrOrderItem {

	function setRank($new_rank){
		return $this->_setRank($new_rank,array(
			"basket_id" => $this->g("basket_id"),
		));
	}

	protected function _getRawUnitPriceInclVat(){
		$p_price = $this->getProductPrice();
		return $p_price->getRawUnitPriceInclVat();
	}

	protected function _getRawUnitPriceBeforeDiscountInclVat(){
		$p_price = $this->getProductPrice();
		return $p_price->getRawUnitPriceBeforeDiscountInclVat();
	}

	function getVatPercent(){
		$price = $this->getProductPrice();
		return $price->getVatPercent();
	}

	function getBasket(){
		return Cache::Get("Basket",$this->g("basket_id"));
	}

	function getProductPrice(){
		$price_finder = $this->getBasket()->getPriceFinder();
		$price = $price_finder->getPrice($this->getProduct(),$this->getAmount(),["return_null_when_price_does_not_exist" => false]);
		return $price;
	}
}
