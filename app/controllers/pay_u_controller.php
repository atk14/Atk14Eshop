<?php
/**
 * Controller for a PayU classic API.
 *
 * A classic API POS (point of sale) needs to be configured in PayU merchant panel.
 *
 * Data coding: UTF-8
 * URLs:
 * - Error return address:      http://atk14eshop.localhost/cs/pay_u/finish_transaction/?session_id=%sessionId%&type=%payType%&error=%error%
 * - Successful return address: http://atk14eshop.localhost/cs/pay_u/finish_transaction/?session_id=%sessionId%&type=%payType%
 * - Address for reports:				http://atk14eshop.localhost/cs/pay_u/update_status/
 */

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

		$this->layout_name = "blank";

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
		
		$payment_form = $pay_u_api->renderForm($transaction,[
			"submit_form_immediately" => true, 
		]);
		$this->tpl_data["payment_form"] = $payment_form;
	}

	function finish_transaction(){
		$payment_transaction = PaymentTransaction::GetInstanceById($this->params->getInt("session_id"));
		if(!$payment_transaction || $payment_transaction->getPaymentGateway()->getCode()!=="pay_u"){
			$this->_redirect_to("payment_transactions/finish");
			return;
		}

		$pay_u = new PaymentGatewayApi\PayU();
		$pay_u->updateStatus($payment_transaction);

		$this->_redirect_to([
			"action" => "payment_transactions/finish",
			"token" => $payment_transaction->getToken(),
		]);
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

		if(!$transaction = PaymentTransaction::FindFirst("id",$this->params->getInt("session_id"))){
			$this->logger->error("there is no PaymentTransaction with id=".$this->params->getInt("session_id"));
			return;
		}

		$pay_u = new PaymentGatewayApi\PayU();
		$pay_u->updateStatus($transaction);
	}
}
