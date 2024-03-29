<?php
class PaymentTransactionsController extends ApplicationController {

	function start(){
		$payment_transaction = $this->payment_transaction;

		if(!$payment_transaction){
			$this->_execute_action("error404");
			return;
		}

		if($payment_transaction->cancelled() && $payment_transaction->isRepeatable()){
			$payment_transaction = $payment_transaction->copyIntoNewTransaction();
		}

		// Ulozeni id transakce pro navrat do payment_transactions/finish.
		// Toto se hodi pro pripad, kdy brana do navratove adresy nevklada zadny identifikator.
		$this->session->s("current_payment_transaction_id",$payment_transaction->getId());

		if(!$payment_transaction->started()){
			$pg_class = String4::ToObject($payment_transaction->getPaymentGateway()->getCode())->camelize()->toString(); // "gp_webpay" -> "GpWebpay"
			$pg_class = "PaymentGatewayApi\\$pg_class";
			$pg = new $pg_class();
			$pg->startTransaction($payment_transaction);
		}

		$this->_redirect_to($payment_transaction->getPaymentTransactionUrl());
	}

	function finish(){
		$this->page_title = _("Platební operace byla dokončena");

		$pt = $this->payment_transaction;

		// Nemame PaymentTransaction -> presmerujeme zakaznika na orders/finish
		if(!$pt){
			$this->_redirect_to([
				"action" => "orders/finish",
			]);
			return;
		}

		// Informace o selhani platbu ted uz tiskneme v orders/finish
		$order = $pt->getOrder();
		$this->_redirect_to([
			"action" => "orders/finish",
			"token" => $order->getToken(),
			"lang" => $order->getLanguage(),
		]);
	}

	function _before_filter(){
		$order = null;
		$pt = null;

		if($this->params->defined("order_token")){
			$order = Order::GetInstanceByToken($this->params->getString("order_token"),["extra_salt" => "payment_transaction_start", "hash_length" => 10]);
			if($order){
				$pt = $order->getPaymentTransaction();
			}
		}elseif($this->params->defined("token")){
			$pt = PaymentTransaction::GetInstanceByToken($this->params->getString("token"));
		}elseif($this->session->defined("current_payment_transaction_id")){
			$pt = PaymentTransaction::GetInstanceById($this->session->g("current_payment_transaction_id"));
		}

		if($pt && !$order){
			$order = $pt->getOrder();
			$pt_recent = $order->getPaymentTransaction(); // the most recent payment transaction
			if($pt->getId()!==$pt_recent->getId()){
				$params = $this->params->toArray();
				$params["token"] = $pt_recent->getToken();
				$params["action"] = $this->action;
				$this->_redirect_to($params); // redirecting to the most recent payment transaction
				return;
			}
		}

		$this->payment_transaction = $this->tpl_data["payment_transaction"] = $pt;
	}
}
