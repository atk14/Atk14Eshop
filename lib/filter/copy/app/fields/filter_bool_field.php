<?php
class FilterBoolField extends ChoiceField implements IFilterFormField {

	var $disabled_choices = array();

	function __construct($options = []){
		$options += [
			"widget" => new RadioSelect(),
			"required" => false,
		];
		$this->section = $options['filter_section'];

		if(!key_exists('choices', $options) || $options['choices'] === null) {
				$options["choices"] = $this->section->getChoices();
		}
		parent::__construct($options);
	}

	function clean($values){
		// Nam to totiz nevadi. Naopak. Kdyz se z filtru ztrati nejaka option, tak neprestanou fungovat zaindexovana URL.
		if(!key_exists($values, $this->choices)) {
			$values = null;
		}
		return parent::clean($values);
	}

	function get_possible_choices(){
		return array_keys($this->choices);
	}

	function update_by_filter() {
			if($this->disabled) { return ; }
			$counts = $this->section->getCounts();
			if(count($counts) > 1) {
				$choices = $this->get_choices();
				foreach($choices as $k => &$c) {
					$c = $c. ' ('.$counts[$k].')';
				}
				$this->set_choices($choices);
			} else {
				$this->disabled = true;
				$this->inital = key($counts);
			}
	}
}
