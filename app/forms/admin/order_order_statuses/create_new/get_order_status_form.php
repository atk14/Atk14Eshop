<?php
class GetOrderStatusForm extends OrderOrderStatusesForm {

	function set_up() {
		$this->set_button_text(_("Continue"));
	}

	function prepare_for_order($order){
		$choices = [];
		foreach($order->getAllowedNextOrderStatuses() as $os){
			$choices[$os->getCode()] = sprintf("[%s] %s",$os->getCode(),$os->getName());
		}
		$this->add_field("order_status", new ChoiceField(array(
			"label" => _("New order status"),
			"choices" => $choices,
		)));
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["order_status"])){
			$d["order_status"] = OrderStatus::GetInstanceByCode($d["order_status"]); // e.g. "payment_accepted" -> OrderStatus#4
		}

		return [$err,$d];
	}
}
