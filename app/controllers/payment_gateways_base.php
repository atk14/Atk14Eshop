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
}
