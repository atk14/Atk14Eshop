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

	static function CreateNewRecord($values,$options = []){
		$values += array(
			"vat_rate_id" => VatRate::GetInstanceByCode("default"),
			"regions" => Region::GetDefaultValueForRegionsColumn(), 
		);

		return parent::CreateNewRecord($values,$options);
	}

	function isActive() {
		return $this->getActive();
	}

	/**
	 * Popis dorucovaci metody pro emailovou notifikaci
	 */
	function getEmailDescription(){
		$out = (string)parent::getEmailDescription();
		if(strlen($out)){ return $out; }
		//
		//$out = $this->getDescription();
		//if(strlen($out)){ return $out; }
		//
		if($this->personalPickup() && ($store = $this->getPersonalPickupOnStore())){
      $out = $store->getAddress(["with_name" => true, "connector" => ", "]);
      if(strlen($out) && $store->getOpeningHours()){
        $out .= ", ".sprintf(_("opening hours: %s"),$store->getOpeningHours());
      }
      $out = strip_tags($out);
      $out = h($out);
			return $out;
		}
	}

	function toString() {
		return (string)$this->getLabel();
	}

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getRequiredCustomerGroup(){
		return Cache::Get("CustomerGroup",$this->getRequiredCustomerGroupId());
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

	function getDeliveryService() {
		return Cache::Get("DeliveryService",$this->getDeliveryServiceId());
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
		",[":delivery_method" => $this]) &&
		!Campaign::FindFirst("required_delivery_method_id",$this);
	}

	function getCode($country = null){
		if($specification = $this->getCountrySpecification($country)){
			return $specification->getCode();
		}
		return $this->g("code");
	}

	function getVatRate($country = null){
		if($specification = $this->getCountrySpecification($country)){
			return $specification->getVatRate();
		}
		return Cache::Get("VatRate",$this->getVatRateId());
	}

	function getVatPercent($country = null){
		if($specification = $this->getCountrySpecification($country)){
			return $specification->getVatPercent();
		}
		return $this->getVatRate()->getVatPercent();
	}

	/**
	 *
	 *	$price = $dm->getPrice(); // vychozi cena
	 *	$price = $dm->getPrice("SK"); // cena muze byt odlisna od ceny vychozi
	 */
	function getPrice($country = null){
		$price_incl_vat = $this->getPriceInclVat($country);
		return ApplicationHelpers::DelVat($price_incl_vat,$this->getVatPercent($country));
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

	/**
	 *
	 *	$lowest_price = $dm->getLowestPrice();
	 *	$lowest_price = $dm->getLowestPrice(["CZ","SK"]);
	 */
	function getLowestPrice($countries = null){
		return $this->_getLowestOrHighestPrice(false,"MIN",$countries);
	}

	/**
	 *
	 *	$lowest_price = $dm->getLowestPriceInclVat();
	 *	$lowest_price = $dm->getLowestPriceInclVat(["CZ","SK"]);
	 */
	function getLowestPriceInclVat($countries = null){
		return $this->_getLowestOrHighestPrice(true,"MIN",$countries);
	}

	/**
	 *
	 *	$highest_price = $dm->getHighestPrice();
	 *	$highest_price = $dm->getHighestPrice(["CZ","SK"]);
	 */
	function getHighestPrice($countries = null){
		return $this->_getLowestOrHighestPrice(false,"MAX",$countries);
	}

	/**
	 *
	 *	$highest_price = $dm->getHighestPriceInclVat();
	 *	$highest_price = $dm->getHighestPriceInclVat(["CZ","SK"]);
	 */
	function getHighestPriceInclVat($countries = null){
		return $this->_getLowestOrHighestPrice(true,"MAX",$countries);
	}

	protected function _getLowestOrHighestPrice($incl_vat,$MAX,$countries){
		$field = $incl_vat ? "price_incl_vat" : "100.0 * (price_incl_vat / (100.0 + (SELECT vat_percent FROM vat_rates WHERE id=delivery_method_country_specifications.vat_rate_id)))";
		$price = $incl_vat ? $this->getPriceInclVat() : $this->getPrice();
		$bind_ar = [":delivery_method" => $this];
		$countries_sql = "";
		if($countries){
			$countries_sql = " AND country IN :countries";
			$bind_ar[":countries"] = $countries;
		}
		$spec_price = $this->dbmole->selectFloat("SELECT $MAX($field) FROM delivery_method_country_specifications WHERE delivery_method_id=:delivery_method$countries_sql",$bind_ar);
		if(!$incl_vat && !is_null($spec_price)){
			$spec_price = round($spec_price,INTERNAL_PRICE_DECIMALS);
		}
		if(!is_null($spec_price) && $countries){
			$cnt = $this->dbmole->selectInt("SELECT COUNT(*) FROM delivery_method_country_specifications WHERE delivery_method_id=:delivery_method$countries_sql",$bind_ar);
			if($cnt == sizeof($countries)){
				return $spec_price;
			}
		}
		if(!is_null($spec_price) && (($MAX=="MAX" && $spec_price>$price) || ($MAX=="MIN" &&  $spec_price<$price))){
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

	function getDesignatedForTagsLister(){
		return $this->getLister("Tags",[
			"table_name" => "delivery_method_designated_for_tags",
		]);
	}

	function getDesignatedForTags(){
		return $this->getDesignatedForTagsLister()->getRecords();
	}

	function getExcludedForTagsLister(){
		return $this->getLister("Tags",[
			"table_name" => "delivery_method_excluded_for_tags",
		]);
	}
		
	function getExcludedForTags(){
		return $this->getExcludedForTagsLister()->getRecords();
	}
}
