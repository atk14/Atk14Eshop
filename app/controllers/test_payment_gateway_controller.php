<?php
require_once(__DIR__ . "/payment_gateways_base.php");

class TestPaymentGatewayController extends PaymentGatewaysBaseController {

	function finish_transaction(){
		$gateway = PaymentGateway::GetInstanceByCode("test_payment_gateway");

		$pt = null;
		if($this->params->defined("transaction_id")){
			$transaction_id = $this->params->getString("transaction_id");
			$pt = PaymentTransaction::FindFirst("payment_transaction_id",$transaction_id,"payment_gateway_id",$gateway,["order_by" => "created_at DESC, id DESC"]);
		}else{
			$pt = PaymentTransaction::FindById($this->session->g("current_payment_transaction_id"));
		}

		if(!$pt || $pt->getPaymentGateway()->getCode()!=="test_payment_gateway"){
			return $this->_execute_action("error404");
		}

		$gateway_api = $pt->getPaymentGatewayApi();
		$gateway_api->updateStatus($pt);

		$this->_redirect_to([
			"action" => "payment_transactions/finish",
			"token" => $pt->getToken(),
		]);
	}
}
