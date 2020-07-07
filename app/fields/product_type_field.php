<?php
class ProductTypeField extends ChoiceField {

	function __construct($options = array()){
		$options += array(
			"empty_choice_text" => "-- "._("typ produktu")." --",
		);

		$choices = array("" => $options["empty_choice_text"]);
		foreach(ProductType::FindAll() as $pt){
			$choices[$pt->getId()] = $pt->getName();
		}
		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
