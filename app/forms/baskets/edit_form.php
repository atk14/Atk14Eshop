<?php
require_once(__DIR__ . "/baskets_form.php"); // Toto tu potrebujeme, nebot se tento formular nahrava i v api/baskets/detail a dalsich API funkci

class EditForm extends BasketsForm {

	function set_up(){
		$this->add_field("voucher", new CharField([
			"max_length" => 50,
			"required" => false,
			"null_empty_output" => true,
		]));
	}

	function set_up_for_basket($basket){
		foreach($basket->getItems() as $item){
			$product = $item->getProduct();
			$id = $item->getId();
			$this->add_field("i$id",new OrderQuantityField($product,[
				"initial" => $item->getAmount(),
			]));
		}
	}
}
