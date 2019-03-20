<?php
class LinkListsForm extends AdminForm {
	function set_up() {
		$this->add_field("name", new CharField(array(
			"label" => _("Orientační název"),
			"help_text" => _("Může obsahovat více informací, například, na které stránce se seznam nachází. Např. 'Patička stránky'.<br>Nezobrazuje se v aplikaci"),
		)));

		$this->add_translatable_field("label", new CharField(array(
			"label" => _("Zobrazený text"),
			"help_text" => _("O nákupu"),
			"required" => false,
		)));
	}
}
