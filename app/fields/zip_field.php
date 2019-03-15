<?php
class ZipField extends RegexField {

	function __construct($options = array()){
		$options += array(
			"null_empty_output" => true,
		);
		parent::__construct('/^\d{3} \d{2}$/',$options);

		$this->update_messages(array("invalid" => _("PSČ zadejte ve tvaru 123 45")));
	}

	function clean($value){
		$value = trim($value);
		$value = preg_replace('/\s+/','',$value); // "123  45" -> "12345"
		$value = preg_replace('/^(\d{3})(\d{2})$/','\1 \2',$value);
		return parent::clean($value);
	}
}
