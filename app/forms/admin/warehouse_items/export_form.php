<?php
class ExportForm extends WarehouseItemsForm {

	function set_up(){
		$this->add_field("format", new ChoiceField([
			"label" => _("Format"),
			"choices" => [
				"xlsx" => "XLSX",
				"csv" => "CSV",
			],
		]));
		$this->add_field("export_all_products", new BooleanField([
			"label" => _("Export all products even when they are not listed in the warehouse?"),
			"required" => false,
			"initial" => true,
		]));

		$this->set_method("get");
		$this->set_hidden_field("warehouse_id",$this->controller->warehouse->getId());
		$this->set_button_text(_("Export"));
	}
}
