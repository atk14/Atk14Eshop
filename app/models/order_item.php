<?php
class OrderItem extends BasketOrOrderItem {

	function setRank($rank){
		$this->_setRank($rank,[
			"order_id" => $this->g("order_id"),
		]);
	}

	protected function _getRawUnitPriceInclVat(){
		return $this->g("unit_price_incl_vat");
	}

	protected function _getRawUnitPriceBeforeDiscountInclVat(){
		return $this->g("unit_price_before_discount_incl_vat");
	}

	function getVatPercent(){
		return $this->g("vat_percent");
	}

	/**
	 * Je tato polozka editovatelna?
	 *
	 * Napr. v adminu.
	 */
	function isEditable(){
		$product = $this->getProduct();
		if(in_array($product->getCode(),["price_rounding"])){
			return false;
		}
		return parent::isEditable();
	}
}
