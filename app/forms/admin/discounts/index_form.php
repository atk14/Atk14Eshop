<?php
class IndexForm extends ApplicationForm {

	function set_up() {
		$this->add_field("products_in_shop", new BooleanField([
			"label" => _("Jen produkty, které se dají koupit"),
			"required" => false,
		]));
		$this->add_field("holder", new ChoiceField([
			"label" => _("Zobrazit pouze"),
			"choices" => [
				"" => "",
				"product" => _("Produkty"),
				"category" => _("Kategorie"),
			],
			"required" => false,
		]));
	}
}
