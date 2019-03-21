<?php
class StoreField extends ChoiceField {

	function __construct($options = []){
		$choices = ["" => ""];
		foreach(Store::FindAll() as $store){
			$choices[$store->getId()] = $store->getName()." - ".$store->getAddress();
		}

		$options["choices"] = $choices;
		parent::__construct($options);
	}
}
