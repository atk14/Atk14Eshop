<?php
class SlidersForm extends AdminForm {
	function set_up(){
		$this->add_field("name", new CharField([
			"label" => _("Název"),
			"max_length" => 255,
		]));
	}
}
