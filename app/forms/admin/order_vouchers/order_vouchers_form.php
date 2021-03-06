<?php
class OrderVouchersForm extends AdminForm {
	
	function set_up(){
		$currency = $this->controller->order->getCurrency();

		$this->add_field("voucher_id", new VoucherField([
			"label" => _("Slevový kupón"),
			"initial_value_is_id" => true,
		]));

		$this->add_field("discount_amount", new PriceField([
			"label" => _("Sleva")." [$currency]",
		]));

		$this->add_field("internal_note", new TextField([
			"label" => _("Interní poznámka"),
			"required" => false,
			"null_empty_output" => true,
		]));
	}
}
