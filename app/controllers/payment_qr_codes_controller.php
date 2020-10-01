<?php
class PaymentQrCodesController extends ApplicationController {

	// http://dumlatek.localhost/qr-code/cs/417681.76e77b8aaf3deed3.png
	function detail(){
		$order = Order::GetInstanceByToken($this->params->getString("order_token"),["extra_salt" => "QrPayment","hash_length" => 16]);
		if(!$order){
			return; $this->_execute_action("error404");
		}

		$payment_method = $order->getPaymentMethod();

		if(!$payment_method->isBankTransfer()){
			return $this->_execute_action("error404");
		}

		$generator = $order->getPaymentQrCodeGenerator();

		$this->render_template = false;
		$this->response->setContentType("image/png");
		$this->response->write($generator->renderPng(["size" => 400]));
	}

	function error404(){
		$this->render_template = false;
		$this->response->notFound(); // generic error
	}
}
