<?php
class FormShowcaseForm extends TestsForm {

	function set_up(){
		$this->add_field("fruits", new MultipleChoiceField([
			"choices" => [
				"apple" => "Apple",
				"orange" => "Orange",
				"banana" => "Banana",
			],
			"help_text" => "MultipleChoiceField",
		]));
		$this->add_field("colors", new MultipleChoiceField([
			"choices" => [
				"red" => "Red",
				"green" => "Green",
				"blue" => "Blue",
			],
			"widget" => new CheckboxSelectMultiple(),
			"help_text" => "MultipleChoiceField with CheckboxSelectMultiple; the choices should be alligned <strong><em>vertically</em></strong>",
		]));
		$this->add_field("vegetables", new MultipleChoiceField([
			"choices" => [
				"potatoe" => "potatoe",
				"cucumber" => "cucumber",
				"caroot" => "caroot",
			],
			"widget" => new CheckboxSelectMultiple([
				"list_attrs" => [
					"class" => "list list--checkboxes list--checkboxes--horizontal",
				],
			]),
			"help_text" => "MultipleChoiceField with CheckboxSelectMultiple; the choices should be alligned <strong><em>horizontally</em></strong>",
		]));

		$this->add_field("boolean", new BooleanField([
			"help_text" => "BooleanField",
		]));
		$this->set_button_text(_("Send"));
	}
}
