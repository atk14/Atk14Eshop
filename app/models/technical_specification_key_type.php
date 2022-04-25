<?php
class TechnicalSpecificationKeyType extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields() { return array("name");}

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getTransformator(){
		$type = new String4($this->getCode()); // "number", "boolean", "care_instructions"

		$class_name = "TechnicalSpecificationKeyType_".$type->camelize(); // "TechnicalSpecificationKeyType_Number", "TechnicalSpecificationKeyType_Boolean", "TechnicalSpecificationKeyType_CareInstructions"
		if(class_exists($class_name)){
			$transformator = new $class_name();
			return $transformator;
		}
	}

	function toString(){
		return (string)$this->getName();
	}
}
