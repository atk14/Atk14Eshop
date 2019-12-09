<?php
class CreatorsForm extends AdminForm {

	function set_up(){
		$this->add_field("name", new CharField([
			"label" => _("Name"),
			"max_length" => 255,
		]));
		$this->add_translatable_field("name_localized", new CharField([
			"label" => _("Localized name"),
			"max_length" => 255,
			"required" => false,
		]));
	}
}
