<?php
/**
 * vychozi field pro widget s vybiratkem pobocky
 * bude se vykreslovat mimo validovany <form>. po vyberu pobocky prenese vybrane id do #delivery_service_branch_id
 * pro ceskou postu zatim pouzivame vychozi naseptavadlo
 * pro Zasilkovnu pouzijeme jejich vlastni widget (@todo)
 */
class BranchSelectorForm extends ApplicationForm {
	function set_up() {

		//$f = $this->add_field("delivery_service_widget", new DeliveryServiceBranchField(array(
		$f = $this->add_field("delivery_service_widget", new CharField(array(
			"label" => _("Výdejní místo"),
			"required" => true,
			"help_text" => _("Zadejte psč, město nebo název provozovny"),
			"delivery_service_id" => $this->controller->delivery_method->getDeliveryService(),
		)));
	}
}
