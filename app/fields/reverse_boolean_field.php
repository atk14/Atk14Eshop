<?php
/**
 * Reverse BooleanField - checked means false, unchecked means true
 */
class ReverseBooleanField extends BooleanField {

	function __construct($options = array()){
		$options += array(
			"initial" => true
		);
		parent::__construct($options);
	}

	function format_initial_data($value){
		$value = parent::format_initial_data($value);
		return isset($value) ? !$value : $value;
	}

	function clean($value){
		list($err,$value) = parent::clean($value);
		$value = isset($value) ? !$value : $value;
		return array($err,$value);
	}
}
