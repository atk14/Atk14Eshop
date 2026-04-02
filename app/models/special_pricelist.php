<?php
class SpecialPricelist extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return array("name"); }

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getCurrency(){
		return Currency::GetDefaultCurrency();
	}

	function containsPricesWithoutVat(){
		return $this->g("contains_prices_without_vat");
	}

	function isDeletable(){
		return true;
	}
}
