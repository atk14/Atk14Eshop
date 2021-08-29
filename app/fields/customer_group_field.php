<?php
class CustomerGroupField extends ChoiceField {

	function __construct($options = []){
		$choices = ["" => ""];
		foreach(CustomerGroup::FindAll() as $cg){
			$choices[$cg->getId()] = $cg->getName();
		}
		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
