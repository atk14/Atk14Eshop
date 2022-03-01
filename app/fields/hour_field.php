<?php
class HourField extends FloatField{

	protected $allow_2400 = false;

	function __construct($options = array()){
		$options += array(
			"allow_2400" => false, // alowes time 24:00
		);

		$this->allow_2400 = $options["allow_2400"];
		unset($options["allow_2400"]);

		parent::__construct($options);

		$this->update_message("invalid_hour_format",_("Toto nevypadá jako zápis hodin. Je očekáván zápis 12:00"));
	}

	function format_initial_data($value){
		Atk14Require::Helper("modifier.float_to_hour");
		return smarty_modifier_float_to_hour($value);
	}

	function clean($value){
		$value = trim($value);
		if(strlen($value)==""){
			return parent::clean(""); // null
		}

		if(is_numeric($value)){
			$value = (int)$value;

		}elseif(preg_match('/^(\d+)\s*:\s*(\d{1,2})$/',$value,$matches)){
			if($matches[2]>59){
				// vice jak 59 minut?
				return array($this->messages["invalid_hour_format"],null);
			}
			$value = $matches[1] + ($matches[2]/60.0);

		}else{
			return array($this->messages["invalid_hour_format"],null);
		}

		if((!$this->allow_2400 && $value>=24.00) || ($this->allow_2400 && $value>24.00)){
			return array($this->messages["invalid_hour_format"],null);
		}

		if($value<0.0){
			return array($this->messages["invalid_hour_format"],null);
		}
	
		return parent::clean($value);
	}
}
