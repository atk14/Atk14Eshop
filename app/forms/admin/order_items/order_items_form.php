<?php
class OrderItemsForm extends AdminForm {

	function set_up(){
		$this->add_field("product_id", new ProductField([
			"label" => _("Produkt"),
		]));

		$this->add_field("amount", new IntegerField([
			"label" => _("Množství"),
			"min_value" => 1,
		]));
	}
}
