<?php
class AddProductForm extends BasketsForm {
	
	function set_up(){
		$this->add_field("amount", new OrderQuantityField($this->controller->product));
	}
}
