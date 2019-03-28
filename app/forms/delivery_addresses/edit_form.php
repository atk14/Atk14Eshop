<?php
class EditForm extends DeliveryAddressesForm {

	function set_up(){
		parent::set_up();
		$this->set_button_text(_("Uložit změny"));
	}
}
