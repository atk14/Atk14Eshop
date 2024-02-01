<?php
class OrderField extends CharField {

	function __construct($options = []){
		parent::__construct($options);

		$this->update_messages([
			"no_such_order" => _("Taková objednávka neexistuje"),
		]);
	}

	function format_initial_data($data){
		if(is_a($data,"Order")){
			return $data->getOrderNo();
		}
		if(is_numeric($data) && ($order = Order::GetInstanceById($data))){
			return $order->getOrderNo();
		}
		return $data;
	}

	function clean($value){
		list($err,$value) = parent::clean($value);

		if(!is_null($err) || is_null($value)){
			return [$err,null];
		}

		$value = Order::FindFirst("order_no",$value);
		if(!$value){
			return [$this->messages["no_such_order"],null];
		}

		return [$err,$value];
	}
}
