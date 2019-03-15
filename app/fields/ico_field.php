<?php
class IcoField extends RegexField{
	function __construct($options = []){
		parent::__construct('/^\d{8}$/',$options);
		
		$this->update_messages(array("invalid" => _("IČ by mělo mít 8 číslic")));
	}

	function clean($value){
		$value = preg_replace('/\s/','',$value); // "123 456 78" -> "12345678"
		return parent::clean($value);
	}
}
