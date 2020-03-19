<?php
class OrderStatus extends ApplicationModel implements Translatable {

	static $Codes_Paid = ["payment_accepted"];
	static $Codes_NotPaid = ["payment_failed","returned_money"];

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

	function getAllowedNextOrderStatusesLister(){
		return $this->getLister("AllowedNextOrderStatuses",[
			"class_name" => "OrderStatus",
		]);
	}

	function getAllowedNextOrderStatuses(){
		return $this->getAllowedNextOrderStatusesLister()->getRecords();
	}

	/**
	 * Oznamuje se tato zmena stavu uzivateli?
	 */
	function notificationEnabled($consider_custom_flag = true){
		$notification_enabled = $this->g("notification_enabled");
		if(!$notification_enabled){
			return false;
		}

		if($consider_custom_flag){
			$notification_enabled = $this->g("custom_notification_enabled");
		}

		return $notification_enabled;
	}

	function isBlockingStockcount(){
		return $this->g("blocking_stockcount");
	}

	function reduceStockount(){
		return $this->g("reduce_stockount");
	}

	function finishedSuccessfully(){
		return $this->g("finished_successfully");
	}

	function finishedUnsuccessfully(){
		return $this->g("finished_unsuccessfully");
	}

	function isFinishingSuccessfully(){
		return $this->g("finishing_successfully");
	}

	function isFinishingUnsuccessfully(){
		return $this->g("finishing_unsuccessfully");
	}
}
