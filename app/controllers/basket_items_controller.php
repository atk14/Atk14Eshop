<?php
class BasketItemsController extends ApplicationController {

	function edit(){
		if(!$this->request->post()){
			return $this->_execute_action("error404");
		}

		$product = $this->basket_item->getProduct();
		$this->form->add_field("amount", new OrderQuantityField($product));

		if($d = $this->form->validate($this->params)){
			$this->basket_item->s($d);
		}

		$this->_redirect_to("baskets/edit");
	}

	function increase_amount(){
		if(!$this->request->post()){
			return $this->_execute_action("error404");
		}

		$product = $this->basket_item->getProduct();
		$amount = $this->basket_item->getAmount();
		$step = $product->getOrderQuantityStep();
		$this->basket->setProductAmount($product,$amount+$step);

		if(!$this->request->xhr()){
			$this->_redirect_to("baskets/edit");
		}
	}

	function decrease_amount(){
		if(!$this->request->post()){
			return $this->_execute_action("error404");
		}

		$product = $this->basket_item->getProduct();
		$amount = $this->basket_item->getAmount();
		$step = $product->getOrderQuantityStep();
		$this->basket->setProductAmount($product,$amount-$step);

		if(!$this->request->xhr()){
			$this->_redirect_to("baskets/edit");
		}
	}

	function destroy(){
		if(!$this->request->post()){
			return $this->_execute_action("error404");
		}

		$this->basket_item->destroy();
		
		if(!$this->request->xhr()){
			$this->_redirect_to("baskets/edit");
		}
	}

	function _before_filter(){
		$bi = $this->_just_find("basket_item");
		if(!$bi){
			$this->_execute_action("error404");
			return;
		}
		$basket = $this->_get_basket();
		if($bi->getBasketId()!==$basket->getId()){
			$this->_execute_action("error403");
			return;
		}

		$this->basket_item = $bi;
	}
}
