<?php
class OrderStatusField extends ObjectStatusField {

	function __construct($options = []){
		$options += [
			"empty_choice_text" => sprintf("-- %s --", _("stav objednávky"))
		];
		parent::__construct($options);
	}
}
