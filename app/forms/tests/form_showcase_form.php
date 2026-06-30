<?php
class FormShowcaseForm extends TestsForm {

	function set_up(){
		$this->add_field("colors", new MultipleChoiceField([
			"choices" => [
				"red" => "Red",
				"green" => "Green",
				"blue" => "Blue",
			],
			"widget" => new CheckboxSelectMultiple(),
		]));
		$this->set_button_text(_("Send"));
	}
}
