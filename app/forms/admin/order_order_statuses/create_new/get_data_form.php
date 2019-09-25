<?php
class GetDataForm extends OrderOrderStatusesForm {

	function set_up(){
		$this->add_field("order_status_note", new TextField(array(
			"label" => _("Note"),
			"required" => false,
		)));

		$this->set_button_text(_("Změnit stav"));
	}

	function add_price_paid_field($order){
		$initial = !is_null($order->getPricePaid()) ? $order->getPricePaid() : $order->getPriceToPay();
		$this->add_field("price_paid", new PriceField([
			"label" => sprintf(_("Zaplacená částka [%s]"),$order->getCurrency()),
			"initial" => $initial,
			"required" => false,
		]));
	}

	function add_tracking_number($order){
		$this->add_field("tracking_number", new CharField([
			"label" => sprintf(_("Kód pro sledování zásilky pro dopravu %s"),$order->getDeliveryMethod()),
			"initial" => $order->getTrackingNumber(),
			"max_length" => 255,
			"null_empty_output" => true,
			"required" => false,
		]));
	}
}
