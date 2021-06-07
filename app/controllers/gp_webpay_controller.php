<?php
require_once(__DIR__ . "/payment_gateways_base.php");

class GpWebpayController extends PaymentGatewaysBaseController {

	function finish_transaction(){
		if($pt = PaymentTransaction::GetInstanceByToken($this->params->getString("token"))){
			myAssert($pt->getPaymentGateway()->getCode()=="gp_webpay"); // just for sure

			$pg = new PaymentGatewayApi\GpWebpay();
			$pg->updateStatus($pt);

			$this->_redirect_to([
				"action" => "payment_transactions/finish",
				"token" => $pt->getToken(),
			]);
		}else{
			$this->_redirect_to("payment_transactions/finish");
		}
	}
}
