<?php
class EditPaymentMethodsForm extends AdminForm {

	function set_up() {
		$payment_method_choices = array();
		foreach(PaymentMethod::FindAll() as $pm) {
			$label = h($pm->getLabel());
			$regions = $pm->getRegions();
			$regions = array_map(function($region){ return $region->getShortcut(); }, $regions);
			$label .= " (".join(", ",$regions).")";
			if(!$pm->isActive()){ $label = "<del title=\""._("neaktivní platební metoda")."\">$label</del>"; }
			
			$payment_method_choices[$pm->getId()] = $label;
		}
		$this->add_field("payment_method_id", new MultipleChoiceField(array(
			"label" => _("Vyberte dostupné způsoby platby"),
			"choices" => $payment_method_choices,
			"widget" => new CheckboxSelectMultiple(["escape_labels" => false]),
			"required" => false,
		)));
	}
}
