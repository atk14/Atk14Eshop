<?php
class BankAccountField extends RegexField {

	function __construct($options = []){
		parent::__construct('/^(\d{0,6}-\d{2,10}|\d{2,10})\/\d{4}$/',$options);
		$this->update_messages(array(
			"invalid" => _("Bankovní účet není zadán správně"),
			"invalid_checksum" => _("Bankovní účet není zadán správně.")." "._("Zkontrolujte prosím překlepy."),
		));
	}

	function clean($value){
		$value = (string)$value;
		$value = preg_replace('/\s+/','',$value);
		list($err,$value) = parent::clean($value);

		if($value){
			// https://github.com/heureka/bank-account-validator
			$validator = new BankAccountValidator\Czech();
			$isValid = $validator->validate($value);
			if(!$isValid){
				return [$this->messages["invalid_checksum"],null];
			}
		}

		return [$err,$value];
	}
}
