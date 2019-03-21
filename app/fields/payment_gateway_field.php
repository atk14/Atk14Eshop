<?php
class PaymentGatewayField extends ChoiceField {

	function __construct($options = []){
		$options += [
			"empty_choice_text" => "",
		];
		$choices = ["" => $options["empty_choice_text"]];
		foreach(PaymentGateway::FindAll() as $pg){
			$choices[$pg->getId()] = $pg->getName();
		}

		$options["choices"] = $choices;

		parent::__construct($options);
	}

	function format_initial_data($value){
		return is_object($value) ? $value->getId() : $value;
	}
}
