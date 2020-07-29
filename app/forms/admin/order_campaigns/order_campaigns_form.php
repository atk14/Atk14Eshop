<?php
class OrderCampaignsForm extends AdminForm {

	function set_up(){

		$currency = $this->controller->order->getCurrency();

		$this->add_field("campaign_id", new CampaignField([
			"label" => _("Kampaň"),
		]));

		$this->add_field("discount_amount", new PriceField([
			"label" => _("Sleva")." [$currency]"
		]));

		$this->add_field("internal_note", new TextField([
			"label" => _("Interní poznámka"),
			"required" => false,
			"null_empty_output" => true,
		]));
	}
}
