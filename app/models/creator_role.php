<?php
class CreatorRole extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return array("name"); }

	function setRank($new_rank){ return $this->_setRank($new_rank); }

	function isDeletable(){
		return 0==$this->dbmole->selectInt("SELECT COUNT(*) FROM card_creators WHERE creator_role_id=:creator_role",[":creator_role" => $this]);
	}

	function toString(){
		return (string)$this->getName();
	}
}
