<?php
class SetBranchForm extends ApplicationForm {
	function set_up() {

		# vychozi field pro widget s vybiratkem pobocky
		# bude se vykreslovat mimo validovany <form>. po vyberu pobocky prenese vybrane id do #delivery_service_branch_id
		# pro ceskou postu zatim pouzivame vychozi naseptavadlo
		# pro Zasilkovnu pouzijeme jejich vlastni widget (@todo)
		$this->add_field("delivery_service_widget", new DeliveryServiceBranchField(array(
			"label" => _("Pobočka"),
			"required" => false,
			"help_text" => _("Zde je widget s vyberem pobocky"),
			"delivery_service_id" => $this->controller->delivery_method->getDeliveryService(),
		)));

		# toto bude validovane
		$this->add_field("delivery_service_branch_id", new DeliveryServiceBranchField(array(
			"label" => _("Pobočka"),
#			"required" => false,
			"help_text" => _("Zadejte PSČ, adresu nebo název místa"),
			"delivery_service_id" => $this->controller->delivery_method->getDeliveryService(),
			"widget" => new HiddenInput()
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
