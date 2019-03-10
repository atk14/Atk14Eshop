<?php
class GenderField extends choiceField {

	function __construct($options = []){
		$options += [
			"initial" => 2, // pani
		];
		
		$choices = [];
		foreach(Gender::GetInstances() as $g){
			$choices[$g->getId()] = $g->getName();
		}

		$options["choices"] = $choices;
		$options["widget"] = new RadioSelect();
		
		parent::__construct($options);
	}

	function format_initial_data($data){
		return is_object($data) ? $data->getId() : $data;
	}
}
