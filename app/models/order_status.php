<?php
class OrderStatus extends ApplicationModel implements Translatable {

	var $next_status = array(
		"new" => array("waiting_for_processing", "waiting_for_bank_transfer", "waiting_for_online_payment"),
		"waiting_for_processing" => array("processing","cancelled"),
		"waiting_for_bank_transfer" => array("waiting_for_processing", "cancelled"),
		"waiting_for_online_payment" => array("payment_accepted", "payment_failed"),
		"payment_accepted" => array("waiting_for_processing"),
		"payment_failed" => array("payment_accepted","waiting_for_processing","waiting_for_bank_transfer","cancelled"),
		"processing" => array("waiting_for_transport", "shipped", "cancelled"),
		"on_the_way" => array("ready"),
		"waiting_for_transport" => array("on_the_way","ready"),
		"processed" => array("ready","ready_reminder","cancelled"),
		"ready" => array("delivered","cancelled","ready_reminder"),
		"ready_reminder" => array("delivered","cancelled","ready_reminder"),
		"shipped" => array("delivered"),
#		"delivered",
#		"cancelled",
	);

	static function GetTranslatableFields() {
		return array("name");
	}

	function toString() {
		return (string)$this->getName();
	}


	static $payment_gateway_to_status_code_map = array(
		1 => "waiting_for_online_payment",
		2 => "waiting_for_online_payment",
#		2 => "waiting_for_bank_transfer",
	);

	static function DetermineInitialStatus($payment_method_id) {
		$payment_method = PaymentMethod::FindById($payment_method_id);

		if ($payment_method->isOnlineMethod()) {
			$status_code = self::$payment_gateway_to_status_code_map[$payment_method->getPaymentGatewayId()];
		} elseif (in_array($payment_method->getCode(), array("cs_banktransfer","ASI-SK-PL-BU","eu_banktransfer"))) {
			$status_code = "waiting_for_bank_transfer";
		} else {
			$status_code = "waiting_for_processing";
		}

		return self::FindByCode($status_code);
	}

	function getNextStatusCodes() {
		if (isset($this->next_status[$this->getCode()])) {
			return $this->next_status[$this->getCode()];
		}
		return null;
	}

	function getNextStatuses() {
		if (isset($this->next_status[$this->getCode()])) {
			$status_finder = self::Finder(array(
				"conditions" => array(
					"code in :next_status_codes",
				),
				"bind_ar" => array(":next_status_codes" => $this->next_status[$this->getCode()]),
				"limit" => null,
			));
			return $status_finder->getRecords();
		}
		return array();
	}

	/**
	 * Oznamuje se tato zmena stavu uzivateli?
	 */
	function notificationEnabled(){
		return in_array($this->getCode(), array("processing", "waiting_for_bank_transfer", "payment_accepted", "payment_failed", "ready", "ready_reminder", "cancelled", "processed", "shipped"));
	}
}
