<?php
class CreateNewForm extends AdminForm {

	function set_up() {
		$this->add_field("adding_card", new CardField(array(
			"label" => _("Product")
		)));

		$this->add_field("also_create_opposite_link", new BooleanField(array(
			"label" => _("Vytvořit také opačnou vazbu?"),
			"required" => false,
			"initial" => true,
		)));

		$this->set_button_text(_("Add product"));
	}
}
