<?php
class Zz01SettingBccEmailForOrderWithdrawalRequestStatusNewMigration extends ApplicationMigration {

	function up(){
		$order_status = OrderStatus::GetInstanceByCode("new");
		$order_withdrawal_request_status =  OrderWithdrawalRequestStatus::GetInstanceByCode("new");

		if($order_withdrawal_request_status->getBccEmail()){
			// the bcc email is already set
			return;
		}

		if($order_status->getBccEmail()){
			$order_withdrawal_request_status->s("bcc_email",$order_status->getBccEmail());
		}
	}
}
