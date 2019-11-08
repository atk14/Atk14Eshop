<?php
class EditDeliveryMethodsForm extends AdminForm {

	function set_up() {
		$delivery_method_choices = array();
		foreach(DeliveryMethod::FindAll() as $pm) {
			$label = $pm->getLabel();
			if($pm->isActive()){
				$label = "<del>$label</del>";
			}
			$delivery_method_choices[$pm->getId()] = $label;
		}
		$this->add_field("delivery_method_id", new MultipleChoiceField(array(
			"label" => _("Vyberte dostupné způsoby dopravy"),
			"choices" => $delivery_method_choices,
			"widget" => new CheckboxSelectMultiple(),
		)));
	}
}
