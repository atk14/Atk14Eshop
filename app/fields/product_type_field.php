<?php
class ProductTypeField extends ObjectChoiceField {

	var $order_by = "rank, id";

	function __construct($options = array()){
		$options += array(
			"empty_choice_text" => "-- "._("typ produktu")." --",
		);

		parent::__construct($options);
	}
}
