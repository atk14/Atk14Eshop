<?php
class TechnicalSpecificationKeyType_Boolean extends TechnicalSpecificationKeyType_Base {

	function __construct(){
		parent::__construct([
			"label" => _("Přepínač"),
			"field_class" => "BooleanWithSelectField",
		]);
	}

	function parseValue($str_value){
		$str_value = String4::ToObject($str_value)->trim()->lower()->toString();
		if(in_array($str_value,[
			"yes",
			"true",
			"on",
			"1",
			"ano",
			_("yes"),
		])){ return true; }

		if(in_array($str_value,[
			"no",
			"false",
			"off",
			"0",
			"ne",
			_("no"),
		])){ return false; }

		return null;
	}
}
