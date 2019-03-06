<?php
class PaymentMethod extends ApplicationModel implements Rankable, Translatable {

	use TraitRegions;

	/**
	 * - label - zobrazi se v nazvu option ve formulari
	 * - title - zahlavi v napovede
	 * - description - dalsi informace o obchode (oteviraci doba, moznosti platby apod.)
	 */
	static function GetTranslatableFields(){ return array("label","title","description"); }

	static function FindByCode($code, $options = array()){
		list($code,$subcode) = preg_split("/\//", "$code/");
		static $Cache=array();
		$options += array(
			"force_read" => TEST,
			"use_cache" => true,
		);
		if(!key_exists($code, $Cache) || $options["force_read"]) {
			$Cache[$code] = parent::FindByCode($code, $options);
		}
		return $Cache[$code];
	}

	function isActive() {
		return $this->getActive();
	}

	function toString() {
		return (string)$this->getLabel();
	}

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function setDeliveryMethods($delivery_methods) {
		return ShippingCombination::SetDeliveryMethodsForPaymentMethod($this,$delivery_methods);
	}

	function getDeliveryMethodIds() {
		return ShippingCombination::GetDeliveryMethodIdsForPaymentMethod($this);
	}

	function getDeliveryMethods() {
		$delivery_ids = $this->getDeliveryMethodIds();
		return DeliveryMethod::GetInstanceById($delivery_ids);
	}

	/**
	 * Je toto online metoda?
	 */
	function isOnlineMethod(){
		return !is_null($this->getPaymentGatewayId());
	}

	function isDeletable(){
		return 0===$this->dbmole->selectInt("
			SELECT COUNT(*) FROM (
				(SELECT id FROM baskets WHERE payment_method_id=:payment_method LIMIT 1)
				UNION
				(SELECT id FROM orders WHERE payment_method_id=:payment_method LIMIT 1)
			)q
		",[":payment_method" => $this]);
	}
}
