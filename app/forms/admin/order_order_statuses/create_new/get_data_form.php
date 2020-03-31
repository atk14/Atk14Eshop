<?php
class GetDataForm extends OrderOrderStatusesForm {

	function set_up(){
		$f = $this->add_field("order_status_note", new TextField(array(
			"label" => _("Internal note"),
			"required" => false,
		)));
		$f->widget->attrs["rows"] = 2;

		$this->set_button_text(_("Změnit stav"));
	}

	function add_price_paid_field($order){
		$initial = !is_null($order->getPricePaid()) ? $order->getPricePaid() : $order->getPriceToPay();
		$this->add_field("price_paid", new PriceField([
			"label" => sprintf(_("Zaplacená částka [%s]"),$order->getCurrency()),
			"initial" => $initial,
			"required" => false,
		]));
		$this->_reorder_fields();
	}

	function add_tracking_number($order){
		$this->add_field("tracking_number", new CharField([
			"label" => sprintf(_("Kód pro sledování zásilky pro dopravu %s"),$order->getDeliveryMethod()),
			"initial" => $order->getTrackingNumber(),
			"max_length" => 255,
			"null_empty_output" => true,
			"required" => false,
		]));
		$this->_reorder_fields();
	}

	// We just want to have the field order_status_note at the end of the field list
	function _reorder_fields(){
		$f = $this->fields["order_status_note"];
		unset($this->fields["order_status_note"]);
		$this->fields["order_status_note"] = $f;
	}
}
