<?php
class ProductPriceBeforeDiscount extends ProductPrice {

	function __construct($product_price){
		$this->data = $product_price->data;
		$this->amount = $product_price->amount;
		$this->currency = $product_price->currency;
		$this->current_date = $product_price->current_date;
	}

	function getRawUnitPrice($incl_vat = false){
		return $this->getRawUnitPriceBeforeDiscount($incl_vat);
	}
}
