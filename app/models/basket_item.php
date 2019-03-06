<?php
definedef("INTERNAL_PRICE_DECIMALS",4);

class BasketItem extends BasketOrOrderItem {

	function setRank($new_rank){
		return $this->_setRank($new_rank,array(
			"basket_id" => $this->g("basket_id"),
		));
	}

	protected function _getRawUnitPrice(){
		$p_price = $this->getProductPrice();
		return round($p_price->getRawUnitPrice(),INTERNAL_PRICE_DECIMALS); // dulezite je to zaokrouhlit na interni pocet des. mist v db, aby se OrderItem::_getRawUnitPrice() chovala stejne
	}

	protected function _getRawUnitPriceBeforeDiscount(){
		$p_price = $this->getProductPrice();
		return round($p_price->getRawUnitPriceBeforeDiscount(),INTERNAL_PRICE_DECIMALS); // dulezite je to zaokrouhlit na interni pocet des. mist v db, aby se OrderItem::_getRawUnitPrice() chovala stejne
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
