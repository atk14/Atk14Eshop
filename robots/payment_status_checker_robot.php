<?php
/**
 * Robot proveruje stavy online plateb
 */
class PaymentStatusCheckerRobot extends ApplicationRobot {

	function run(){
		//$TESTING_PAYMENTS_ONLY = !PRODUCTION;
		$TESTING_PAYMENTS_ONLY = false;

		$order_status_id = "(SELECT order_status_id FROM orders WHERE id=payment_transactions.order_id)";
		$conditions = [
			"payment_transaction_started_at IS NOT NULL",
			"payment_status_id=:pending_status OR payment_status_id IS NULL",
			"(payment_transaction_started_at<NOW() - INTERVAL '5 minutes') OR payment_status_id=:pending_status", // nekontroluji se uplne nove platebni transakce - ocekava se, ze stav zaplaceni oznami plat. brana push zpravou
			"
				(payment_transaction_started_at>NOW() - INTERVAL '24 hours') OR -- 1 den se pravidelne kontroluji nezaplacene platby
				(payment_transaction_started_at>NOW() - INTERVAL '10 days' AND $order_status_id=:payment_failed_order_status AND COALESCE(payment_status_checked_at,created_at)<NOW() - INTERVAL '30 minutes') -- a pak kazdou pulhodinu u objednavek ve stavu payment_failed
			", // 
		];

		$bind_ar = [
			":pending_status" => PaymentStatus::FindByCode("pending"),
			":payment_failed_order_status" => OrderStatus::FindByCode("payment_failed"),
		];

		if($TESTING_PAYMENTS_ONLY){
			$conditions[] = "testing_payment";
		}

		$payment_transactions = PaymentTransaction::FindAll([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
		]);

		$this->logger->info("payment transactions to check: ".sizeof($payment_transactions));

		foreach($payment_transactions as $payment_transaction){
			$current_status = $payment_transaction->getPaymentStatus() ? $payment_transaction->getPaymentStatus()->getCode() : "NULL";
			$order = $payment_transaction->getOrder();
			$order_no = $order->getOrderNo();
			$order_id = $order->getId();
			$this->logger->info("about to check status of $payment_transaction (current status: $current_status, Order#$order_id, order_no=$order_no)");
			$this->logger->flush();
			$gateway = $payment_transaction->getPaymentGateway();
			$code = $gateway->getCode();
			$gw_class = String4::ToObject($code)->camelize()->toString(); // "gp_webpay" -> "GpWebpay"
			$gw_class = "PaymentGatewayApi\\$gw_class";
			$this->dbmole->begin();
			$gw = new $gw_class([
				"logger" => $this->logger
			]);
			$gw->updateStatus($payment_transaction);
			$this->dbmole->commit();
		}
	}
}
