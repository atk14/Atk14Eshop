<?php
class Gender extends ApplicationModel implements Translatable, Rankable {

	private static $Instances;

	static function GetTranslatableFields(){ return array("name"); }

	function setRank($rank){
		$this->_setRank($rank);
	}

	static function GetInstances(){
		if(!self::$Instances){
			self::$Instances = self::FindAll(["use_cache" => true]);
		}
		return self::$Instances;
	}

	function isFemale(){
		return $this->getSex()=="f";
	}

	function isMale(){
		return $this->getSex()=="m";
	}

	function toString(){ return (string)$this->getName(); }
}
