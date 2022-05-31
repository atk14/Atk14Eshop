<?php
class SetRegionForm extends ApplicationForm {

	function set_up(){
		$choices = [];
		// Region::GetActiveInstances() may differ from $this->controller->_get_allowed_regions()
		foreach($this->controller->_get_allowed_regions() as $region){
			$choices[$region->getId()] = $region->getName();
		}

		$this->set_attr("id","form_regions_set_region");

		$this->add_field("id", new ChoiceField([
			"label" => _("Selling region"),
			"choices" => $choices,
			"initial" => $this->controller->current_region->getId(),
		]));

		$this->set_action(Atk14Url::BuildLink([
			"namespace" => "",
			"controller" => "regions",
			"action" => "set_region",
		]));
	}
}
