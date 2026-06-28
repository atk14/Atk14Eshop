<?php
class GetOrderForm extends OrderWithdrawalRequestsForm {

	function set_up(){
		$this->add_field("order_no", new CharField([
			"label" => _("Číslo objednávky"),
			"max_length" => 20,
		]));

		$this->set_button_text(_("Pokračovat"));
	}
}
