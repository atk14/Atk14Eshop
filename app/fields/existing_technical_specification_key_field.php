<?php
class ExistingTechnicalSpecificationKeyField extends ObjectChoiceField {

	function __construct($options = []){
		$options["class_name"] = "TechnicalSpecificationKey";
		$options += [
			"order_by" => "rank, id",
		];

		parent::__construct($options);
	}
}
