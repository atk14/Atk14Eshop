<?php
require_once(__DIR__ . "/../iobjects_form.php");

class CardPromotionsForm extends IobjectsForm {

	function set_up(){
		$this->add_field("card_id", new CardField([
			"label" => _("Product"),
		]));
	}
}
