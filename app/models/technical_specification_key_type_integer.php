<?php
class TechnicalSpecificationKeyType_Integer extends TechnicalSpecificationKeyType_Base {

	function __construct(){
		parent::__construct([
			"label" => _("Celé číslo")
		]);
	}

	function parseValue($str_value){
		$str_value = String4::ToObject($str_value)
			->trim()
			->gsub('/^\+\s*/','') // "+ 12" -> "12"
			->gsub('/^-\s*/','-') // "- 12" -> "-12"
			->gsub('/\s*[a-zA-Z]+$/','') // "12 kg" -> "12"
			->gsub('/(\d)\s*/','\1') // "123 456" -> "123456"
			->toString();
		$int = (int)$str_value;
		if("$str_value" === "$int"){
			return $int;
		}
	}
}
