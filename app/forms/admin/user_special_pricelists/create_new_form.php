<?php
class CreateNewForm extends AdminForm {

	function set_up(){
		$this->add_field("pricelist_id", new SpecialPricelistField([
			"label" => _("Special price list"),
		]));
	}
}
