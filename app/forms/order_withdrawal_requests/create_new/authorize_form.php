<?php
class AuthorizeForm extends OrderWithdrawalRequestsForm {

	function set_up(){
		$this->add_field("code", new OneTimePasswordCodeField([
			"label" => _("Číselný kód"),
		]));
		$this->set_button_text(_("Ověřit kód"));
	}
}
