<?php
class GetOrderItemForm extends VouchersForm {

	function set_up(){
		$this->add_field("order_item", new ChoiceField([
			"label" => _("Položka objednávky"),
			"widget" => new RadioSelect(),
		]));

		$this->set_button_text(_("Pokračovat"));
	}

	function tune_for_order($order){
		$choices = [];

		foreach($order->getOrderItems() as $item){
			$product = $item->getProduct();
			if($product->getCode()==="price_rounding"){ continue; }
			$choices[$item->getId()] = sprintf("%s%s %s",$item->getAmount(),$product->getUnit(),$product);
		}

		if(sizeof($choices)==1){
			$keys = array_keys($choices);
			$this->set_initial("order_item",$keys[0]);
		}

		$this->fields["order_item"]->set_choices($choices);
	}

	function clean(){
		list($err,$d) = parent::clean();

		if($d){
			$d["order_item"] = OrderItem::GetInstanceById($d["order_item"]);
			myAssert($d["order_item"]);
		}

		return [$err,$d];
	}
}
