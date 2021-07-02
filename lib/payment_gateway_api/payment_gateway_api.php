<?php
namespace PaymentGatewayApi;

class PaymentGatewayApi {

	protected $set_new_new_transaction_to_started_state = true;

	function __construct($options = []){
		global $ATK14_GLOBAL, $HTTP_REQUEST;

		$options += [
			"logger" => $ATK14_GLOBAL->getLogger(),
			"request" => $HTTP_REQUEST,
		];

		$this->logger = $options["logger"];
		$this->request = $options["request"];
	}

	function testingApi(){
		$class = get_class($this);
		throw new \Exception("Method $class::testingApi() needs to be defined");
	}

	final function startTransaction(&$payment_transaction){
		myAssert(!$payment_transaction->started());

		$transaction_id = null;
		$url = $this->_getStartTransactionUrl($payment_transaction,$transaction_id);
		myAssert(strlen($url)>0);
		myAssert(is_bool($this->testingApi()));

		$values = [
			"payment_transaction_url" => $url,
			"payment_transaction_id" => $transaction_id,
			"testing_payment" => $this->testingApi(),
		];

		if($this->set_new_new_transaction_to_started_state){
			$values["payment_transaction_started_at"] = now();
			$values["payment_transaction_started_from_addr"] = $this->request->getRemoteAddr();
		}

		$payment_transaction->s($values);
	}

	final function updateStatus(&$payment_transaction){
		$code = $this->_getCurrentPaymentStatusCode($payment_transaction);
		if(is_null($code)){
			return;
		}

		$status = \PaymentStatus::FindByCode($code);
		myAssert(is_object($status));

		$current_status = $payment_transaction->getPaymentStatus();
		if(!$current_status || $current_status->getId()!=$status->getId()){
			$order = $payment_transaction->getOrder();
			$order_current_status = $order->getOrderStatus();

			$this->logger->info(sprintf("order_no %s, payment_transaction_id %s: payment status updated: %s -> %s",$order->getOrderNo(),$payment_transaction->getId(),$current_status ? $current_status->getCode() : "",$status->getCode()));
			$payment_transaction->setNewPaymentStatus($status);

			$order_status = $order->getOrderStatus();
			if($order_current_status->getId()!=$order_status->getId()){
				$this->logger->info(sprintf("order_no %s, order status updated: %s -> %s",$order->getOrderNo(),$order_current_status->getCode(),$order_status->getCode()));
			}

		}else{
			// nic se nemeni -> pouze se zauktualizuje payment_status_checked_at
			$payment_transaction->s([
				"payment_status_checked_at" => now(),
				"updated_at" => $payment_transaction->g("updated_at"),
			]);
		}
	}

	/**
	 *
	 *	$code = $this->_getCurrentPaymentStatusCode($payment_transaction); // "pending", "paid", "cancelled", null
	 */
	protected function _getCurrentPaymentStatusCode(&$payment_transaction){
		$class = get_class($this);
		throw new \Exception("Method $class::_getCurrentPaymentStatusCode(&\$payment_transaction) needs to be defined");
	}

	/**
	 *
	 *	$url = $this->_getStartTransactionUrl($payment_transaction,$transaction_id);
	 *	echo $url; // "https://..."	
	 *	echo $transaction_id; // e.g. "A2HW-1WPE-XMG5"
	 */
	protected function _getStartTransactionUrl(&$payment_transaction,&$transaction_id){
		$class = get_class($this);
		throw new \Exception("Method $class::_getStartTransactionUrl(&\$payment_transaction,&\$transaction_id) needs to be defined");
	}
}
