<?php
class PricelistItem extends ApplicationModel {

	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
	}

}
