<?php
class TechnicalSpecificationKeyType_Integer extends TechnicalSpecificationKeyType_Base {

	function __construct(){
		parent::__construct([
			"label" => _("Celé číslo")
		]);
	}

	function parseValue($str_value){
		$int = (int)$str_value;
		if($str_value === "$int"){
			return $int;
		}
	}
}
