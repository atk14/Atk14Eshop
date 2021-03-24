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

	function getVatRateId(){
		return $this->_getSelfOrProxy("vat_rate_id");
	}

	function getVatRate(){
		return Cache::Get("VatRate",$this->getVatRateId());
	}

	function getVatPercent(){
		return $this->getVatRate()->getVatPercent();
	}

	function getPrice(){
		return ApplicationHelpers::DelVat($this->getPriceInclVat(),$this->getVatPercent());
	}

	function getPriceInclVat(){
		return $this->_getSelfOrProxy("price_incl_vat");
	}

	function _getSelfOrProxy($key){
		$value = $this->g("$key");
		return is_null($value) ? $this->getDeliveryMethod()->g("$key") : $value;
	}

}
