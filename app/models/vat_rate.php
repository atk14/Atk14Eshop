<?php
class VatRate extends ApplicationModel implements Translatable, Rankable {
	
	static function GetTranslatableFields(){ return array("name"); }

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
