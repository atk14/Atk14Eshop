<?php
class PickerableDateField extends DateField {

	function __construct($options = []){
		$options += [
			"widget" => new DateInput(),
		];
		parent::__construct($options);
	}

	function format_initial_data($value){
		$value = (string)$value;
		if(preg_match('/^(\d{4}-\d{2}-\d{2})/',$value,$matches)){
			return $matches[1];
		}
		return parent::format_initial_data($value);
	}

	function clean($value){
		$value = (string)$value;
		$value = trim($value);
		if(preg_match('/^(\d{4}-\d{2}-\d{2})/',$value,$matches) && Date::ByDate($matches[1])){
			return [null,$matches[1]];
		}
		return parent::clean($value);
	}
}
