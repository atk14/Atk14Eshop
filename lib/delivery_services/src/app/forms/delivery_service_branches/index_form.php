<?php
class IndexForm extends ApplicationForm {

	function set_up(){
		$f = $this->add_field("q", new CharField(array(
			"label" => _("Vyhledat výdejní místo"),
			"help_text" => _("Začněte psát PSČ, adresu nebo název místa"),
			"max_length" => 200,
			"required" => false,
		)));
		$f->widget->attrs["class"] = "text form-control js--delivery_branch_search_input";
		$f->widget->attrs["autocomplete"] = "off";

		$this->set_button_text(_("Hledat"));
	}
}
