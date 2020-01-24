<?php
class TagsForm extends AdminForm{

	function set_up(){
		$this->add_field("tag", new CharField(array(
			"label" => _("Tag"),
			"max_length" => 255,
			"hint" => "rumors",
		)));

		$this->add_translatable_field("tag_localized", new CharField([
			"label" => _("Tag lokalized"),
			"max_length" => 255,
			"required" => false,
			"help_text" => _("Enter proper value when the tag itself is not good in the given language"),
		]));

		$choices = array();
		$choices[""] = _("default color");
		// These color list was taken from public/styles/_bootstrap_variables.scss
		foreach(array(
			"blue" => _("blue"),
			"indigo" => _("indigo"),
			"purple" => _("purple"),
			"pink" => _("pink"),
			"red" => _("red"),
			"orange" => _("orange"),
			"yellow" => _("yellow"),
			"green" => _("green"),
			"teal" => _("teal"),
			"cyan" => _("cyan"),
			"white" => _("white"),
			"gray" => _("gray"),
			"gray-dark" => _("dark gray"),
		) as $color => $label){
			$choices["$color"] = "<span class=\"color-sample bg-$color\"></span> $label";
		}
		$this->add_field("color", new ChoiceField([
			"label" => _("Color"),
			"choices" => $choices,
			"required" => false,
			"widget" => new RadioSelect([
				"convert_html_special_chars" => false,
			]),
		]));

		$this->add_code_field();
	}
}
