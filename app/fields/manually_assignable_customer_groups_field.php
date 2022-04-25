<?php
class ManuallyAssignableCustomerGroupsField extends MultipleChoiceField {
	
	function __construct($options = []){
		$choices = [];
		$disabled_choices = [];
		foreach(CustomerGroup::FindAll() as $cg){
			$choices[$cg->getId()] = $cg->isManuallyAssignable() ? h($cg->getName()) : '<span class="text-muted">'.h($cg->getName()).'</span>';
			if(!$cg->isManuallyAssignable()){
				$disabled_choices[] = $cg->getId();
			}
		}
		$options["choices"] = $choices;

		$options["widget"] = new DisableableCheckboxSelectMultiple([
			"escape_labels" => false,
			"disabled_choices" => $disabled_choices,
		]);

		parent::__construct($options);
	}

	function format_initial_data($value){
		$value = TableRecord::ObjToId($value); // CustomerGroup[] -> integer[]
		return $value;
	}

	function clean($value){
		list($err,$value) = parent::clean($value);
		if(!is_null($err) || is_null($value)){ return [$err,$value]; }

		$out = [];
		foreach(CustomerGroup::FindAll() as $cg){
			if(!$cg->isManuallyAssignable()){ continue; }
			if(!in_array((string)$cg->getId(),$value)){ continue; }
			$out[] = $cg;
		}

		if(!$out && $this->required){
			return [$this->messages["required"],null];
		}

		return [$err,$out];
	}
}
