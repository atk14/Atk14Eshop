<?php
class DeliveryMethod extends ApplicationModel implements Rankable, Translatable {

	use TraitCodebook;
	use TraitRegions;

	/**
	 * - label - zobrazi se v nazvu option ve formulari
	 * - title - zahlavi v napovede
	 * - description - dalsi informace o obchode (oteviraci doba, moznosti platby apod.)
	 */
	static function GetTranslatableFields() {
		return array("label","title","description","email_description");
	}

	/**
	 * Najde delivery_type podle kodu.
	 *
	 * Lze zadat vcetne kodu pobocky, pokud muze mit nejaky dorucovaci zpusob vice moznosti.
	 * Pobocek muze byt mnoho na to, aby se importovaly do ciselniku.
	 * V ciselniku je ale jen jeden zaznam spolecne pro vsechny pobocky.

	 * Napriklad Ceska Posta - balik na postu. Tato moznost ma jeden spolecny kod CP_np pro jakoukoliv vybranou postu.
	 * Soucasti kodu muze byt psc posty, napr.: CP_np/13001
	 * Takto se cely kod posila do service.
	 *
	 */
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

	/**
	 * Popis dorucovaci metody pro emailovou notifikaci
	 */
	function getEmailDescription(){
		$out = parent::getEmailDescription();
		if(strlen($out)){ return $out; }
		return $this->getDescription();
	}

	function toString() {
		return (string)$this->getLabel();
	}

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function setPaymentMethods($payment_methods) {
		return ShippingCombination::SetPaymentMethodsForDeliveryMethod($this,$payment_methods);
	}

	function getPaymentMethodIds() {
		return ShippingCombination::GetPaymentMethodIdsForDeliveryMethod($this);
	}

	function getPaymentMethods() {
		$payment_ids = $this->getPaymentMethodIds();
		return PaymentMethod::GetInstanceById($payment_ids);
	}

	function personalPickup() {
		return $this->getPersonalPickup();
	}

	function getPersonalPickupOnStore() {
		return Cache::Get("Store",$this->getPersonalPickupOnStoreId());
	}

	/**
	 * Vrati vsechny zeme, kam je mozne dorucit zasilku s touto dopravou
	 *
	 * @return string[]
	 */
	function getDeliveryCountriesAllowed($curent_region = null){
		$countries = [];
		foreach($this->getRegions() as $region){
			foreach($region->getDeliveryCountries() as $dc){
				$countries[] = $dc;
			}
		}
		$countries = array_unique($countries);
		$countries = array_values($countries);
		
		if($curent_region){
			$countries = array_intersect($countries,$curent_region->getDeliveryCountries());
			$countries = array_values($countries);
		}

		return $countries;
	}

	function isDeletable(){
		return 0===$this->dbmole->selectInt("
			SELECT COUNT(*) FROM (
				(SELECT id FROM baskets WHERE delivery_method_id=:delivery_method LIMIT 1)
				UNION
				(SELECT id FROM orders WHERE delivery_method_id=:delivery_method LIMIT 1)
			)q
		",[":delivery_method" => $this]);
	}

	function getCode($country = null){
		if($specification = $this->getCountrySpecification($country)){
			return $specification->getCode();
		}
		return $this->g("code");
	}

	/**
	 *
	 *	$price = $dm->getPrice(); // vychozi cena
	 *	$price = $dm->getPrice("SK"); // cena muze byt odlisna od ceny vychozi
	 */
	function getPrice($country = null){
		if($specification = $this->getCountrySpecification($country)){
			return $specification->getPrice();
		}
		return $this->g("price");
	}

	/**
	 *
	 *	$price = $dm->getPriceInclVat(); // vychozi cena s DPH
	 *	$price = $dm->getPriceInclVat("SK"); // cena s DPH muze byt odlisna od vychozi ceny s DPH
	 */
	function getPriceInclVat($country = null){
		if($specification = $this->getCountrySpecification($country)){
			return $specification->getPriceInclVat();
		}
		return $this->g("price_incl_vat");
	}

	function getLowestPriceInclVat(){
		$price = $this->getPriceInclVat();
		$spec_price = $this->dbmole->selectFloat("SELECT MIN(price_incl_vat) FROM delivery_method_country_specifications WHERE delivery_method_id=:delivery_method",[":delivery_method" => $this]);
		if(isset($spec_price) && $spec_price<$price){
			return $spec_price;
		}
		return $price;
	}

	function getHighestPriceInclVat(){
		$price = $this->getPriceInclVat();
		$spec_price = $this->dbmole->selectFloat("SELECT MAX(price_incl_vat) FROM delivery_method_country_specifications WHERE delivery_method_id=:delivery_method",[":delivery_method" => $this]);
		if(isset($spec_price) && $spec_price>$price){
			return $spec_price;
		}
		return $price;
	}

	/**
	 *	$specification = $delivery_method->getCountrySpecification("SK");
	 *	if($specification){
	 *		$new_price = $specification->getPrice();
	 *		$new_price_incl_vat = $specification->getPriceInclVat();
	 *	}
	 */
	function getCountrySpecification($country){
		if(!$country){ return null; }
		return DeliveryMethodCountrySpecification::FindFirst("delivery_method_id",$this,"country",$country);
	}

	/**
	 * Povinne vyzadovane klicove slovo
	 *
	 * Pokud ma dorucovaci metoda povinne klicove slovo,
	 * lze tuto metody pouzit jen v pripade, ze vsechny produkty
	 * v kosiku maji toto klicove slovo.
	 */
	function getRequiredTag(){
		return Cache::Get("Tag",$this->getRequiredTagId());
	}
}
