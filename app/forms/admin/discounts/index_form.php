<?php
class IndexForm extends ApplicationForm {

	function set_up() {
		$this->add_field("holder", new ChoiceField([
			"label" => _("Show only"),
			"choices" => [
				"" => "-- "._("show only")." --",
				"product" => _("products"),
				"category" => _("categories"),
			],
			"required" => false,
		]));
	}
}
