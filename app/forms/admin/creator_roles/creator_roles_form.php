<?php
class CreatorRolesForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
			"max_length" => 255,
		)));

		$this->add_code_field();
	}
}
