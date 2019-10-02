<?php
class PriceField extends LocalizedDecimalField {

	function __construct($options = []){
		$options += [
			"min_value" => 0.0,

			"max_digits" => 20,
			"decimal_places" => 6,
			"format_number" => false,
		];

		parent::__construct($options);
	}
}
