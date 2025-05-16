<?php
class DateInput extends TextInput {

	var $input_type = "date";

	function value_from_datadict($data, $name){
		if(isset($data[$name]) && is_string($data[$name])){
			$value = trim($data[$name]);
			if(!preg_match('/^\d{4}-\d{2}-\d{2}$/',$value)){
				return Atk14Locale::ParseDate($value);
			}
		}

		return parent::value_from_datadict($data, $name);
	}

}
