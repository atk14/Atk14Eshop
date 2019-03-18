<?php
class DeliveryMethodCountrySpecification extends ApplicationModel {

	function getDeliveryMethod(){
		return Cache::Get("DeliveryMethod",$this->getDeliveryMethodId());
	}

	function getCode(){
		return $this->_getSelfOrProxy("code");
	}

	function getPrice(){
		return $this->_getSelfOrProxy("price");
	}

	function getPriceInclVat(){
		return $this->_getSelfOrProxy("price_incl_vat");
	}

	function _getSelfOrProxy($key){
		$value = $this->g("$key");
		return is_null($value) ? $this->getDeliveryMethod()->g("$key") : $value;
	}

}
