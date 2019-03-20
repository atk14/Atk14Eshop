<?php
class BasketVouchersController extends ApplicationController {

	function destroy(){
		if(!$this->request->post()){
			return $this->_execute_action("error404");
		}

		$this->basket_voucher->destroy();
		
		$this->flash->notice(_("Slevový kupón byl odebrán"));
		$this->_redirect_to($this->_link_to("baskets/edit")."#vouchers");
	}

	function _before_filter(){
		$bv = $this->_just_find("basket_voucher");
		if(!$bv){
			$this->_execute_action("error404");
			return;
		}
		$basket = $this->_get_basket();
		if($bv->getBasketId()!==$basket->getId()){
			$this->_execute_action("error403");
			return;
		}

		$this->basket_voucher = $bv;
	}
}
