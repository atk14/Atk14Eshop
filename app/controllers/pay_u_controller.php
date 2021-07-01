<?php
require_once(__DIR__ . "/payment_gateways_base.php");

class PayUController extends PaymentGatewaysBaseController {

	function start_transaction(){
		if(!$order = Order::GetInstanceByToken($this->params->getString("token"))){
			return $this->_execute_action("error404");
		}

		if($order->isPaid()){
			return $this->_execute_action("error404");
		}

		// 
		$pay_u_gateway = PaymentGateway::GetInstanceByCode("pay_u");
		$transaction = PaymentTransaction::GetCurrentPaymentTransactionForOrder($order);

		if(!$transaction || $transaction->getPaymentGatewayId()!==$pay_u_gateway->getId()){
			return $this->_execute_action("error404");
		}

		if(!$transaction->isRepeatable()){
			return $this->_execute_action("error404");
		}

		$this->page_title = _("Úhrada objednávky");

		// pri opakovanem navstiveni tohoto URL dochazi k vytvoreni nove transakce
		if($transaction->g("payment_transaction_started_at")){
			$transaction = $transaction->copyIntoNewTransaction();
		}

		$transaction->s([
			"payment_transaction_started_at" => now(),
			"payment_transaction_started_from_addr" => $this->request->getRemoteAddr(),
		]);

		// pri novem i opakovenem vgeneratePayuSessionIdstupu do PayU transakce se renderuje nove payu_session_id
		//$psid = $order->generatePayuSessionId();
		//$this->logger->info(sprintf("order %s: new PayU session ID generated: %s",$order->getOrderNo(),$psid));

		$pay_u_api = new PaymentGatewayApi\PayU();
		
		$payment_form = $pay_u_api->renderForm($transaction);
		$this->tpl_data["payment_form"] = $payment_form;
	}

	function update_status(){
		$this->logger->info("pay_u/update_status post dump");
		$this->logger->info("request_uri: ".$this->request->getRequestUri());
		$this->logger->info("request_method: ".$this->request->getMethod());
		$this->logger->info("raw_post_data:\n".$this->request->getRawPostData());
		$this->logger->info("params:\n".print_r($this->params->toArray(),true));
		$this->logger->info("remote addr: ".$this->request->getRemoteAddr());
		$this->render_template = false;
		$this->response->write("OK");

		if(!$transaction = PayuTransaction::FindFirst("id",$this->params->getString("session_id"))){
			$this->logger->error("there is no PayuTransaction with id=".$this->params->getString("session_id"));
			return;
		}

		$pay_u = new PaymentGatewayApi\PayU();
		$pay_u->updatePayuStatus($transaction);
	}

	function _before_render(){
		parent::_before_render();
		$this->_prepare_checkout_navigation();
	}
}
