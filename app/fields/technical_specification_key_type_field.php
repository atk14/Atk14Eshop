<?php
class TechnicalSpecificationKeyTypeField extends ChoiceField {

	function __construct($options = []){

		$choices = [];
		foreach(TechnicalSpecificationKeyType::FindAll() as $type){
			$choices[$type->getId()] = $type->getName();
		}

		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
