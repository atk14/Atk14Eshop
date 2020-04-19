<?php
class PaymentMethod extends ApplicationModel implements Rankable, Translatable {

	use TraitCodebook;
	use TraitRegions;

	/**
	 * - label - zobrazi se v nazvu option ve formulari
	 * - title - zahlavi v napovede
	 * - description - dalsi informace o obchode (oteviraci doba, moznosti platby apod.)
	 */
	static function GetTranslatableFields(){ return array("label","title","description"); }

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

	function getPaymentGateway(){
		return Cache::Get("PaymentGateway",$this->getPaymentGatewayId());
	}

	function isBankTransfer(){
		return $this->g("bank_transfer");
	}

	function isCashOnDelivery(){
		return $this->g("cash_on_delivery");
	}

	/**
	 * Je toto online metoda?
	 */
	function isOnlineMethod(){
		// Even the bank transfer can be processed through a payment gateway
		return !is_null($this->getPaymentGatewayId()) && !$this->isBankTransfer();
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
