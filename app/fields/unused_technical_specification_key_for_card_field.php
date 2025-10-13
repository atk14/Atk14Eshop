<?php
class UnusedTechnicalSpecificationKeyForCardField extends ExistingTechnicalSpecificationKeyField {

	function __construct($card,$options = []){
		parent::__construct($options);

		$choices = $this->get_choices();

		// filter out the empty choice
		unset($choices[""]);

		// filter out the already taken choices
		$tech_specs = $card->getTechnicalSpecifications();
		$taken_key_ids = array_map(function($ts){ return $ts->getTechnicalSpecificationKeyId(); },$tech_specs);
		foreach($choices as $k => $v){
			if(in_array($k,$taken_key_ids)){ unset($choices[$k]); }
		}

		$this->set_choices($choices);
	}
}
