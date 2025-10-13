<?php
class TechnicalSpecificationKeyType_Integer extends TechnicalSpecificationKeyType_Base {

	function __construct($options = []){
		$options += [
			"label" => _("Celé číslo")
		];
		parent::__construct($options);
	}

	function parseValue($str_value){
		$str_value = String4::ToObject($str_value)
			->trim()
			->gsub('/^\+\s*/','') // "+ 12" -> "12"
			->gsub('/^-\s*/','-') // "- 12" -> "-12"
			->gsub('/\s*[a-zA-Z]+(|\/(m2|m3))$/','') // "12 kg" -> "12", "123 g/m2" -> "123"
			->gsub('/(\d)\s*/','\1') // "123 456" -> "123456"
			->toString();
		$int = (int)$str_value;
		if("$str_value" === "$int"){
			return $int;
		}
	}

	function shouldBeContentValuePreserved($str_value){
		$parsed_value = $this->parseValue($str_value);
		return "$parsed_value" !== "$str_value";
	}
}
