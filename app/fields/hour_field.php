<?php
class HourField extends FloatField{

	function __construct($options = array()){
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

		if($value<0.0 || $value>=24.0){
			return array($this->messages["invalid_hour_format"],null);
		}
	
		return parent::clean($value);
	}
}
