<?php
class CreatorRole extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return array("name","plural_name"); }

	function setRank($new_rank){ return $this->_setRank($new_rank); }

	function getPluralName($lang = null){
		$plural_name = parent::getPluralName($lang);
		if(!strlen((string)$plural_name)){
			$plural_name = parent::getName($lang);
		}
		return $plural_name;
	}

	function isDeletable(){

		return 0==$this->dbmole->selectInt("SELECT COUNT(*) FROM card_creators WHERE creator_role_id=:creator_role",[":creator_role" => $this]);
	}

	function toString(){
		return (string)$this->getName();
	}
}
