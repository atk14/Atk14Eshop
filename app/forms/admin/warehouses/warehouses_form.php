<?php
class WarehousesForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
		)));

		$this->add_field("applicable_to_eshop", new BooleanField(array(
			"label" => _("Applicable to eshop?"),
			"required" => false,
			"initial" => true,
		)));

		$this->add_code_field();
	}
}
