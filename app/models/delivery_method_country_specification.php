<?php
class DeliveryMethodCountrySpecification extends ApplicationModel {

	static function CreateNewRecord($values,$options = []){
		$values += array(
			"vat_rate_id" => VatRate::GetInstanceByCode("default"),
		);

		return parent::CreateNewRecord($values,$options);
	}

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
