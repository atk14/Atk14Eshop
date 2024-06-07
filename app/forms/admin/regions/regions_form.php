<?php
class RegionsForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField([
			"label" => _("Name"),
			"max_length" => 255,
		]));

		$this->add_translatable_field("short_name", new CharField([
			"label" => _("Shortcut"),
			"max_length" => 10,
			"required" => false,
		]));

		$this->add_field("active", new BooleanField(array(
			"label" => _("Is active?"),
			"initial" => true,
			"required" => false,
		)));

		$this->add_field("delivery_countries", new CountriesField([
			"label" => _("Delivery to countries"),
			"required" => true,
			"help_text" => "Comma-separated list of country codes",
		]));

		$this->add_field("currencies", new CurrenciesField([
			"label" => _("Supported currencies"),
			"json_encode" => true,
			"required" => true,
			"max_choice_items" => 1,
		]))->update_messages([
			"max_choice_items_1" => _("Currently, only one currency can be selected.")
		]);

		$this->add_code_field([
			"required" => true,
			"disabled" => true,
		]);
	}
}
