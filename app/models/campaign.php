<?php
class Campaign extends ApplicationModel implements Translatable {

	use TraitRegions;
	
	static function GetTranslatableFields(){ return array("name"); }	

	function freeShipping(){
		return $this->g("free_shipping");
	}

	function isActive(){
		return $this->g("active");
	}

	function getRequiredCustomerGroup(){
		return Cache::Get("CustomerGroup",$this->getRequiredCustomerGroupId());
	}

	function getRequiredDeliveryMethod(){
		return Cache::Get("DeliveryMethod",$this->getRequiredDeliveryMethodId());
	}

	function getRequiredPaymentMethod(){
		return Cache::Get("PaymentMethod",$this->getRequiredPaymentMethodId());
	}

	function hasBeenUsed(){
		return 0<$this->dbmole->selectInt("SELECT COUNT(*) FROM (SELECT id FROM order_campaigns WHERE campaign_id=:campaign LIMIT 1)q",[":campaign" => $this]);
	}

	function isDeletable(){
		return !$this->hasBeenUsed();
	}

	function getDeliveryMethod(){
		return Cache::Get("DeliveryMethod",$this->getDeliveryMethodId());
	}

	function toString(){
		return (string)$this->getName();
	}
}
