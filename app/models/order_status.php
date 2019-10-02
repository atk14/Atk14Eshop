<?php
class OrderStatus extends ApplicationModel implements Translatable {

	use TraitGetInstanceByCode; // $status = OrderStatus::GetInstanceByCode("new");

	static function GetTranslatableFields() {
		return array("name");
	}

	function toString() {
		return (string)$this->getName();
	}

	static function DetermineNextAutomaticStatus($order) {
		$payment_method = $order->getPaymentMethod();

		$status_code = null;
		if($payment_method->isBankTransfer()){
			$status_code = "waiting_for_bank_transfer";
		}elseif($payment_method->isOnlineMethod()){
			$status_code = "waiting_for_online_payment";
		}

		if($status_code){
			$sc = self::FindByCode($status_code);
			myAssert($sc);
			return $sc;
		}
	}

	function getAllowedNextOrderStatuses(){
		$tr_table = [];

		$tr_table["new"] = [
			"processing",
			"cancelled"
		];

		$tr_table["waiting_for_bank_transfer"] = [
			"payment_accepted",
			"payment_failed",
			"cancelled",
		];

		$tr_table["payment_accepted"] = [
			"processing",
			"cancelled",
		];

		$tr_table["payment_failed"] = [
			"waiting_for_bank_transfer",
			"waiting_for_online_payment",
			"processing",
			"cancelled",
		];

		$tr_table["processing"] = [
			"shipped",
			"ready_for_pickup",
			"cancelled"
		];

		$tr_table["shipped"] = [
			"delivered",
			"cancelled",
			"returned"
		];

		$tr_table["ready_for_pickup"] = [
			"delivered",
			"returned",
		];

		$tr_table["delivered"] = [
			"returned",
		];

		$tr_table["returned"] = [
			"cancelled",
		];

		$code = $this->getCode();
		if(!isset($tr_table[$code])){ return []; }

		$out = [];
		foreach($tr_table[$code] as $c){
			$out[] = OrderStatus::GetInstanceByCode($c);
		}

		return $out;
	}

	/**
	 * Oznamuje se tato zmena stavu uzivateli?
	 */
	function notificationEnabled(){
		return $this->g("notification_enabled");
	}

	function isBlockingStockcount(){
		return $this->g("blocking_stockcount");
	}

	function reduceStockount(){
		return $this->g("reduce_stockount");
	}

	function finishedSuccessfully(){
		return in_array($this->getCode(),["shipped","delivered"]);
	}

	function finishedUnsuccessfully(){
		return in_array($this->getCode(),["cancelled","returned"]);
	}
}
