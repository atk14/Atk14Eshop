<?php
class Zz01AddingNextAllowedStatusesForWaitingForOnlinePaymentMigration extends ApplicationMigration {

	function up(){
		$this->_appendNextOrderStatuses("waiting_for_online_payment",[
			"processing",
			"payment_accepted",
			"payment_failed",
			"cancelled",
		]);
	}
}
