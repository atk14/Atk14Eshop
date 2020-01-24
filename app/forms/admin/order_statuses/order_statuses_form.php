<?php
class OrderStatusesForm extends AdminForm {

	function set_up(){
		$this->add_code_field();
		$this->add_translatable_field("name", new CharField([
			"label" => _("Název"),
		]));
		$this->add_field("bcc_email", new CharField([
			"label" => _("BCC e-mail"),
			"null_empty_output" => true,
			"required" => false,
			"help_text" => _("Notifications can be sent to this address or addresses as blind copies."),
			"hints" => [
				"john@doe.com",
				"john@doe.com, bobby@doe.com",
			],
		]));
	}
}
