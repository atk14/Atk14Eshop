<?php
class DetailForm extends ApplicationForm {

	function set_up(){
		$this->add_field("size", new IntegerField([
			"min_value" => 50,
			"max_value" => 1000,
			"initial" => 400,
			"required" => false,
		]));

		$this->add_field("margin", new IntegerField([
			"min_value" => 0,
			"max_value" => 10,
			"initial" => 4,
			"required" => false,
		]));

		$this->add_field("background", new ChoiceField([
			"choices" => [
				"white" => "white",
				"transparent" => "transparent",
			],
			"initial" => "white",
			"required" => false,
		]));
	}

	function clean(){
		list($err,$d) = parent::clean();

		$keys = array_keys($d);
		foreach(array_keys($this->fields) as $f){
			if(in_array($f,$keys) && !isset($d[$f])){
				$d[$f] = $this->get_initial($f);
			}
		}

		return array($err,$d);
	}
}
