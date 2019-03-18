<?php
class PaymentTransaction extends ApplicationModel {

	static function CreateNewRecord($values,$options = []){
		$values += [
			"secret" => (string)String4::RandomString(8),
		];

		return parent::CreateNewRecord($values,$options);
	}

	function getToken($options = []){
		if(is_string($options)){
			$options = array("extra_salt" => $options);
		}
		$options += array(
			"salt" => $this->getSecret(),
			"extra_salt" => "",
		);
		return parent::getToken($options);
	}

	function getOrder(){
		return Cache::Get("Order",$this->getOrderId());
	}

	function getPaymentStatus(){
		return Cache::Get("PaymentStatus",$this->getPaymentStatusId());
	}

	/**
	 *
	 * !! Pozor !! Meni to stav objednavky
	 */
	function setNewPaymentStatus($payment_status){
		$order = $this->getOrder();
		$payment_method = $order->getPaymentMethod();
		$current_order_status = $order->getOrderStatus();
		$current_status = $this->getPaymentStatus();

		myAssert(is_null($current_status) || $current_status->getId()!=$payment_status->getId());

		$code = $payment_status->getCode(); // "pending", "paid"...
		
		$tr = [
			"pending" => "waiting_for_online_payment",
			"paid" => "payment_accepted",
			"cancelled" => "payment_failed",
		];

		if(isset($tr[$code]) && $payment_method->isOnlineMethod() && $current_order_status->getCode()=='waiting_for_online_payment'){
			// zmena stavu online platby meni i stav objednavky, ale pouze za urcitych okolnosti
			$order->setNewOrderStatus($tr[$code]);
		}

		$this->s([
			"payment_status_id" => $payment_status,
			"payment_status_updated_at" => now(),
			"payment_status_checked_at" => now(),
		]);
	}
	
	/**
	 * Zacala jiz tato platebni transakce?
	 */
	function started(){
		return !is_null($this->g("payment_transaction_started_at"));
	}

	/**
	 * * true -> testovaci platba
	 * * false -> produkcni platba
	 * * null -> nevi se
	 */
	function testingPayment(){
		return $this->getTestingPayment();
	}
}
