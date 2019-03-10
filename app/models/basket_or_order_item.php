<?php
class BasketOrOrderItem extends ApplicationModel implements Rankable {

	/**** Nasledujici 4 metody musi predefinovat potomek ****/

	// Pro implementaci Rankable
	function setRank($rank){
		$class = get_class($this);
		throw new Exception("$class::setRank() has to be redefined");
	}

	// Nezaokrouhlena jedn. cena bez DPH
	protected function _getRawUnitPrice(){
		$class = get_class($this);
		throw new Exception("$class::_getRawUnitPrice() has to be redefined");
	}

	// Nezaokrouhlena jedn. cena pred slevou bez DPH
	protected function _getRawUnitPriceBeforeDiscount(){
		$class = get_class($this);
		throw new Exception("$class::_getRawUnitPriceBeforeDiscount() has to be redefined");
	}

	// Procenta DPH
	function getVatPercent(){
		$class = get_class($this);
		throw new Exception("$class::getVatPercent() has to be redefined");
	}

	/********************************************************/




	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
	}

	function getRawUnitPrice($incl_vat = false){
		$price = $this->_getRawUnitPrice();
		$price = $this->_addVat($price,$incl_vat);
		return $price;
	}

	function getRawUnitPriceInclVat(){
		return $this->getRawUnitPrice(true);
	}

	function getUnitPrice($incl_vat = false){
		$price = $this->getRawUnitPrice($incl_vat);
		$price = $this->_roundUnitPrice($price);
		return $price;
	}

	function getRawUnitPriceBeforeDiscount($incl_vat = false){
		$price = $this->_getRawUnitPriceBeforeDiscount();
		if(is_null($price)){
			$price = $this->_getRawUnitPrice();
		}
		$price = $this->_addVat($price,$incl_vat);
		return $price;
	}

	function getRawUnitPriceBeforeDiscountInclVat(){
		return $this->getRawUnitPriceBeforeDiscount(true);
	}

	function getUnitPriceBeforeDiscount($incl_vat = false){
		$price = $this->getRawUnitPriceBeforeDiscount($incl_vat);
		$price = $this->_roundUnitPrice($price);
		return $price;
	}

	function getAmount(){
		if($this->hasKey("amount")){
			return $this->g("amount");
		}
		$class = get_class($this);
		throw new Exception("$class::getAmount() has to be redefined");
	}

	function getCatalogId() {
		return $this->getProduct()->getCatalogId();
	}

	// --

	/**
	 * Celkova cena polozky
	 *
	 * !! Dochazi zde k zaokrouhleni typicky na 2 des mista.
	 */
	function getPrice($incl_vat = false){
		$unit_price = $this->getUnitPrice($incl_vat);
		if(!is_null($unit_price)){
			$price = $unit_price * $this->getAmount();
			$price = $this->_roundItemPrice($price);
			return $price;
		}
	}

	/**
	 * Celkova cena polozky pred slevou
	 *
	 * !! Dochazi zde k zaokrouhleni typicky na 2 des mista.
	 */
	function getPriceBeforeDiscount($incl_vat = false){
		$unit_price = $this->getUnitPriceBeforeDiscount($incl_vat);
		if(!is_null($unit_price)){
			$price = $unit_price * $this->getAmount();
			$price = $this->_roundItemPrice($price);
			return $price;
		}
	}

	function getUnitPriceInclVat(){
		return $this->getUnitPrice(true);
	}

	function getPriceInclVat(){
		return $this->getPrice(true);
	}

	function getPriceBeforeDiscountInclVat(){
		return $this->getPriceBeforeDiscount(true);
	}

  /**
   *  if($item->discounted()){
   *    // a! toto je sleva
   *  }
   */
  function discounted(){
    return $this->getUnitPrice()<$this->getUnitPriceBeforeDiscount();
  }

	/**
	 * Je tato polozka editovatelna?
	 *
	 * Napr. v adminu.
	 */
	function isEditable(){
		return true;
	}

	/**
	 * Je tato polozka smazatelna?
	 */
	function isDeletable(){
		return $this->isEditable();
	}

	function getCurrency(){
		if(is_a($this,"BasketItem")){
			return $this->getBasket()->getCurrency();
		}
		return $this->getOrder()->getCurrency();
	}

	protected function _addVat($price,$add_vat = true){
		if(is_null($price) || !$add_vat){ return $price; }
		return $price * (1.0 + $this->getVatPercent() / 100.0);
	}

	protected function _roundItemPrice($price,$round_for_real = true){
		if(is_null($price) || !$round_for_real){ return $price; }
		
		$currency = $this->getCurrency();
		return $currency->roundPrice($price);
	}

	protected function _roundUnitPrice($price){
		$precision = $this->getProduct()->getUnit()->getUnitPriceRoundingPrecision();
		return round($price,$precision);
	}

	protected function _getUnitPriceRoundingPrecision(){
		return $this->getProduct()->getUnit()->getPriceRoundingPrecision();
	}
}
