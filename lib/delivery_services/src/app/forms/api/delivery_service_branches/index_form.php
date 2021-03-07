<?php
class IndexForm extends ApiForm{

	function set_up(){
		$this->add_field("delivery_service_id", new IntegerField(array(
		)));

		$this->add_field("q",new CharField(array(
			"help_text" => _("Search term"),
			"max_length" => 255,
			"required" => false,
		)));
	}
}
