<?php
class EditPrimaryCardNamesForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
		)));

		$this->add_slug_field();

		$this->set_button_text(_("Sloučit produkty"));
	}
}
