<?php
require_once(__DIR__ . "/payment_gateways_base.php");

class GoPayController extends PaymentGatewaysBaseController {

	function finish_transaction(){
		$this->_finish_transaction([
			"parameter_name" => "id"
		]);
	}

	function update_status(){
		$gateway_code = "go_pay";
		$parameter_name = "id";

		$this->render_template = false;

		$gateway = PaymentGateway::GetInstanceByCode($gateway_code);

		$pt = null;
		if($this->params->defined($parameter_name)){
			$transaction_id = $this->params->getString($parameter_name);
			$pt = PaymentTransaction::FindFirst("payment_transaction_id",$transaction_id,"payment_gateway_id",$gateway,["order_by" => "created_at DESC, id DESC"]);
		}

		if(!$pt || $pt->getPaymentGateway()->getCode()!==$gateway_code){
			$this->response->setStatusCode(404);
			return;
		}

		$gateway_api = $pt->getPaymentGatewayApi();
		$gateway_api->updateStatus($pt);
	}
}
