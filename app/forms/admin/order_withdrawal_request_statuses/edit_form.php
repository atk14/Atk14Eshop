<?php
class EditForm extends OrderWithdrawalRequestStatusesForm {

	function set_up(){
		parent::set_up();

		$this->fields["code"]->disabled = true;

		if($this->controller->order_withdrawal_request_status->notificationEnabled()){
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
