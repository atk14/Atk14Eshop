<?php
class SetBranchForm extends ApplicationForm {

	function set_up() {
		$this->add_field("delivery_service_branch_id", new DeliveryServiceBranchField($this->controller->delivery_method->getDeliveryService(),[
			"label" => _("Pobočka"),
			"help_text" => _("Zadejte PSČ, adresu nebo název místa"),
			"widget" => new HiddenInput()
		]));

		$this->set_button_text(_("Vybrat výdejní místo"));
		$this->set_attr("class",USING_BOOTSTRAP3 ? "hidden" : "d-none");
	}

	function clean() {
		list($err, $d) = parent::clean();

		if (isset($d["delivery_service_branch_id"])) {
			if ($this->controller->delivery_method->getDeliveryServiceId() != $d["delivery_service_branch_id"]->getDeliveryServiceId()) {
				$this->set_error("delivery_service_branch_id", _("Neplatná pobočka"));
			}
		}
		return [$err,$d];
	}
}
