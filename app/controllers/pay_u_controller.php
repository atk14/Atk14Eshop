<?php
require_once(__DIR__ . "/payment_gateways_base.php");

class PayUController extends PaymentGatewaysBaseController {

	function start_transaction(){
		if(!$order = Order::GetInstanceByToken($this->params->getString("token"))){
			return $this->_execute_action("error404");
		}

		// 
		$pay_u_gateway = PaymentGateway::GetInstanceByCode("pay_u");
		$transaction_id = $this->dbmole->selectInt("
			SELECT id FROM payment_transactions
			WHERE
				order_id=:order
			ORDER BY	
				COALESCE(payment_status_id,0)=:status_paid DESC, -- zaplacena transakce ma absolutni prednost
				COALESCE(payment_status_id,0)=:status_cancelled ASC, -- zrusene transakce budou na konci seznamu
				created_at DESC, id DESC -- dale rozhoduje cerstvost zaznamu, novejsi je vyse
		",[
			":order" => $order,
			":status_paid" => PaymentStatus::GetInstanceByCode("paid"),
			":status_cancelled" => PaymentStatus::GetInstanceByCode("cancelled"),
		]);
		$transaction = PaymentTransaction::GetInstanceById($transaction_id);

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

	function _before_render(){
		parent::_before_render();
		$this->_prepare_checkout_navigation();
	}
}
