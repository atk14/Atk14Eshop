<?php
class OrderStatusesForm extends AdminForm {

	function set_up(){
		$this->add_code_field();
		$this->add_translatable_field("name", new CharField([
			"label" => _("Název"),
		]));
	}
}
