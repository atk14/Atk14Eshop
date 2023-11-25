<?php
class IndexForm extends ApplicationForm {

	var $prefix = "delivery_service_branches";

	function set_up(){
		$f = $this->add_field("q", new CharField(array(
			"label" => _("Vyhledat výdejní místo"),
			"help_text" => _("Začněte psát PSČ, adresu nebo název místa"),
			"max_length" => 200,
			"required" => false,
		)));
		$f->widget->attrs["class"] = "text form-control js--delivery_branch_search_input";
		$f->widget->attrs["autocomplete"] = "off";
		$f->widget->attrs["placeholder"] = _("Začněte psát PSČ, adresu nebo název místa");

		$this->set_button_text(_("Hledat"));
		$this->prefix = ("delivery_branch_search");
	}
}
