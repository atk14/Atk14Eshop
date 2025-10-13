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
		if(!$p_price->priceExists()){
			return null;
		}
		return round($p_price->getRawUnitPriceInclVat(),INTERNAL_PRICE_DECIMALS); // dulezite je to zaokrouhlit na interni pocet des. mist v db, aby se OrderItem::_getRawUnitPrice() chovala stejne
	}

	protected function _getRawUnitPriceBeforeDiscountInclVat(){
		$p_price = $this->getProductPrice();
		if(!$p_price->priceExists()){
			return null;
		}
		return round($p_price->getRawUnitPriceBeforeDiscountInclVat(),INTERNAL_PRICE_DECIMALS); // dulezite je to zaokrouhlit na interni pocet des. mist v db, aby se OrderItem::_getRawUnitPrice() chovala stejne
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

	function setAmount($amount){
		$amount = (int)$amount;
		if($amount===$this->getAmount()){ return; }
		$basket = $this->getBasket();
		$basket->setProductAmount($this->getProduct(),$amount);
	}

	function canAmountBeIncreased(){
		$product = $this->getProduct();
		$amount = $this->getAmount();
		$step = $product->getOrderQuantityStep();
		$basket = $this->getBasket();
		$price_finder = $basket->getPriceFinder();

		return $product->canBeOrdered(["amount" => $amount + $step, "price_finder" => $price_finder]);
	}

	function canAmountBeDecreased(){
		$product = $this->getProduct();
		$amount = $this->getAmount();
		$step = $product->getOrderQuantityStep();

		return ($amount - $step) >= $product->getCalculatedMinimumQuantityToOrder();
	}
}
