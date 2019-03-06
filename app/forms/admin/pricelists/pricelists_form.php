<?php
class PricelistsForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
		)));

		$this->add_code_field();
	}
}
