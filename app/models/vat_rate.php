<?php
defined("DEFAULT_VAT_RATE") || define("DEFAULT_VAT_RATE","standard"); // can be NULL

class VatRate extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;
	
	static function GetTranslatableFields(){ return array("name"); }

	static function GetDefaultVatRate(){
		return self::GetInstanceByCode(DEFAULT_VAT_RATE);
	}

	function setRank($rank){
		$this->_setRank($rank);
	}

	function isDeletable(){
		if($this->getCode()=="default"){
			return false;
		}
		return !$this->dbmole->selectInt("SELECT COUNT(*) FROM (SELECT id FROM products WHERE vat_rate_id=:vat_rate LIMIT 1)q",[":vat_rate" => $this]);
	}
}
