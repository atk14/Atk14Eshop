<?php
class PriceField extends FloatField {

	function __construct($options = []){
		$options += [
			"min_value" => 0.0,
		];

		parent::__construct($options);
	}
}
