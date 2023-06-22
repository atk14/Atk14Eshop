<?php
class PaymentGatewaysBaseController extends ApplicationController {

	function update_status(){
		$this->_execute_action("error404");
	}

	function finish_transaction(){
		if($pt = $this->_find_payment_transaction()){
			$this->_redirect_to([
				"action" => "payment_transactions/finish",
				"token" => $pt->getToken(),
			]);
			return;
		}
		$this->_execute_action("error404");
	}

	function _before_filter(){
		$this->_log_request();
	}

	function _find_payment_transaction(){
		return null;
	}

	function _log_request(){
		$title = "$this->controller/$this->action request dump";
		$this->logger->info(
			"$title\n".
			str_repeat("-",strlen($title))."\n".
			"remote addr: ".$this->request->getRemoteAddr()."\n".
			"request_uri: ".$this->request->getRequestUri()."\n".
			"request_method: ".$this->request->getMethod()."\n".
			"raw_post_data:\n".$this->request->getRawPostData()."\n".
			"params:\n".print_r($this->params->toArray(),true)
		);
	}

	function _finish_transaction($options = []){
		$options += [
			"gateway_code" => String4::ToObject(get_class($this))->gsub('/Controller$/i','')->underscore()->toString(), // GoPayController -> go_pay
			"parameter_name" => "",
		];

		$gateway_code = $options["gateway_code"];
		$parameter_name = $options["parameter_name"];

		$gateway = PaymentGateway::GetInstanceByCode($gateway_code);

		$pt = null;
		if($this->params->defined($parameter_name)){
			$transaction_id = $this->params->getString($parameter_name);
			$pt = PaymentTransaction::FindFirst("payment_transaction_id",$transaction_id,"payment_gateway_id",$gateway,["order_by" => "created_at DESC, id DESC"]);
		}else{
			$pt = PaymentTransaction::FindById($this->session->g("current_payment_transaction_id"));
		}

		if(!$pt || $pt->getPaymentGateway()->getCode()!==$gateway_code){
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
