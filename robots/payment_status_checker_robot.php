<?php
/**
 * Robot proveruje stavy online plateb
 */
class PaymentStatusCheckerRobot extends ApplicationRobot {

	function run(){
		//$TESTING_PAYMENTS_ONLY = !PRODUCTION;
		$TESTING_PAYMENTS_ONLY = false;

		$conditions = [
			"payment_transaction_started_at IS NOT NULL",
			"payment_transaction_started_at<NOW() - INTERVAL '5 minutes'", // nekontroluji se uplne nove platebni transakce - ocekava se, ze stav zaplaceni oznami plat. brana push zpravou
			"payment_transaction_started_at>NOW() - INTERVAL '12 hours'", // pouze 12 hodin se kontroluji nezaplacene platby - pak uz to je na rucnim zpracovani...
			"payment_status_id=:pending_status OR payment_status_id IS NULL",
		];

		$bind_ar = [
			":pending_status" => PaymentStatus::FindByCode("pending"),
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
			$this->logger->info("about to check status of $payment_transaction");
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
