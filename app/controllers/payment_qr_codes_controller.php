<?php
class PaymentQrCodesController extends ApplicationController {

	function detail(){
		$order = Order::GetInstanceByToken($this->params->getString("order_token"),["extra_salt" => "QrPayment","hash_length" => 16]);
		if(!$order){
			return; $this->_execute_action("error404");
		}

		$payment_method = $order->getPaymentMethod();

		// When online payment fails, the bank transfer can be offered to the customer...
		//if(!$payment_method->isBankTransfer()){
		//	return $this->_execute_action("error404");
		//}

		$generator = PaymentQrCodeGenerator::GetInstanceForOrder($order);

		if(!$generator){
			return $this->_execute_action("error404");
		}

		$this->render_template = false;
		$this->response->setContentType("image/png");
		$this->response->write($generator->renderPng(["size" => 400]));
	}

	function error404(){
		$this->render_template = false;
		$this->response->notFound(); // generic error
	}
}
