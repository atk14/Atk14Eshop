<?php
class VatPercentField extends LocalizedDecimalField {

	function __construct($options = []){
		$options["min_value"] = 0;
		$options["max_value"] = 100;
		$options["decimal_places"] = 2;
		parent::__construct($options);
	}
}
