<?php
class SetBranchForm extends ApplicationForm {
	function set_up() {
		$this->add_field("delivery_service_branch_id", new DeliveryServiceBranchField(array(
			"label" => _("Pobočka"),
			"required" => false,
			"help_text" => _("Zadejte PSČ, adresu nebo název místa"),
			"delivery_method_id" => $this->controller->delivery_method,
		)));

		$this->set_button_text(_("Pokračovat"));
	}

	function clean() {
		list($err, $d) = parent::clean();

		if (isset($d["delivery_service_branch_id"])) {
			if ($this->controller->delivery_method->getDeliveryServiceId() != $d["delivery_service_branch_id"]->getDeliveryServiceId()) {
				$this->set_error("delivery_service_branch_id", _("Neplatná pobočka"));
			}
		}
		return array($err,$d);
	}
}
