<?php
class AuthorizeForm extends OrderWithdrawalRequestsForm {

	function set_up(){
		$this->add_field("code", new CharField([
			"label" => _("Číselný kód"),
			"max_length" => 20,
		]));
		$this->set_button_text(_("Ověřit kód"));
	}
}
