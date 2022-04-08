<?php
class SetRegionForm extends ApplicationForm {

	function set_up(){
		$choices = [];
		foreach(Region::GetActiveInstances() as $region){
			$choices[$region->getId()] = $region->getName();
		}

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
