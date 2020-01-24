<?php
class EditForm extends OrderStatusesForm {

	function set_up(){
		parent::set_up();

		$this->fields["code"]->disabled = true;

		if(!$this->controller->order_status->notificationEnabled()){
			$this->fields["bcc_email"]->disabled = true;
		}
	}
}
