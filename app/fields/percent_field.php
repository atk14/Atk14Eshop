<?php
class PercentField extends IntegerField {

	function __construct($options = []){
		$options += [
			"min_value" => 0,
			"max_value" => 100,
		];

		parent::__construct($options);
	}
}
