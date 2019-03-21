<?php
class CreateNewForm extends DeliveryMethodCountrySpecificationsForm {

	function set_up(){
		parent::set_up();
		$this->set_button_text(_("Aktualizovat")); // Chceme, aby to vypadalo jako editace...
	}
}
