<?php
class ImportForm extends WarehouseItemsForm {

	function set_up(){
		$this->add_field("ignore_unknown_products", new BooleanField([
			"label" => _("Ignore unknown products?"),
			"initial" => true,
			"required" => false,
		]));

		$this->add_field("delete_unlisted_entries", new BooleanField([
			"label" => _("Delete unlisted entries?"),
			"initial" => false,
			"required" => false,
		]));

		$this->add_field("csv", new TextField([
			"label" => _("CSV data"),
			"help_text" => _("Copy the CSV data right from the Excel"),
			"trim_value" => true,
		]));

		$this->set_button_text(_("Import"));
	}

	function clean(){
		list($err,$d) = parent::clean();

		return [$err,$d];
	}
}
