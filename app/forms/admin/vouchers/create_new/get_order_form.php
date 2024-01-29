<?php
class GetOrderForm extends VouchersForm {

	function set_up(){
		$this->add_field("order", new OrderField([
			"label" => _("Číslo objednávky"),
		]));
	}
}
