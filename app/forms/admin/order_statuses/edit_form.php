<?php
class EditForm extends OrderStatusesForm {

	function set_up(){
		parent::set_up();

		$this->fields["code"]->disabled = true;

		if($this->controller->order_status->notificationEnabled()){
			$this->add_field("custom_notification_enabled", new BooleanField([
				"label" => _("Enable notification"),
				"required" => false,
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
}
