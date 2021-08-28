<?php
class CustomerGroup extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return ["name"]; }

	function setRank($rank){
		$this->_setRank($rank);
	}

	function isManuallyAssignable(){
		return $this->g("manually_assignable");
	}

	function isDeletable(){
		return
			$this->isManuallyAssignable() &&
			!DeliveryMethod::FindFirst("required_customer_group_id",$this) &&
			!PaymentMethod::FindFirst("required_customer_group_id",$this);
	}

	function toString(){
		return (string)$this->getName();
	}
}
