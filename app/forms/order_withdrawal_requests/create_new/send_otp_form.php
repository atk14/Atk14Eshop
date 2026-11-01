<?php
class SendOtpForm extends OrderWithdrawalRequestsForm {

	function set_up(){
		$this->set_button_text(_("Odeslat kód"));
	}
}
