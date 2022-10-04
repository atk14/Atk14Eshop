<?php
class SetPaymentAndDeliveryMethodForm extends CheckoutsForm {

	function set_up(){
		$basket = $this->controller->basket;

		$this->add_field("delivery_method_id",new DeliveryMethodAtCheckoutField([
			"label" => _("Select shipping method"),
			"basket" => $basket,
			"controller" => $this->controller,
			"online_payment_methods_required" => $basket->onlinePaymentMethodRequired(),
		]));

		$this->add_field("payment_method_id",new PaymentMethodAtCheckoutField([
			"label" => _("Select payment method"),
			"basket" => $basket,
			"online_payment_methods_required" => $basket->onlinePaymentMethodRequired(),
		]));

		$this->set_button_text(_("Continue"));
	}

	function clean() {
		list($err, $d) = parent::clean();

		if (isset($d["delivery_method_id"]) && isset($d["payment_method_id"]) && !ShippingCombination::IsAllowed($d["delivery_method_id"], $d["payment_method_id"])) {
			$this->set_error(_("Illegal combination of shipping and payment"));
		}

		return array($err,$d);
	}
}
