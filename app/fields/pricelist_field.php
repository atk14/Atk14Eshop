<?php
class PricelistField extends ObjectChoiceField {
	
	function __construct($options = []){
		$options += [
			"value_formatter" => function($pricelist){
				return $pricelist->getName();
			}
		];
		parent::__construct($options);
	}
}
