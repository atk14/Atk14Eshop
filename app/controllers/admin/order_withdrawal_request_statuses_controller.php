<?php
class OrderWithdrawalRequestStatusesController extends AdminController {

	function edit(){
		$this->_edit([
			"page_title" => _("Editace stavu žádosti o odstoupení od smlouvy"),
		]);
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("order_withdrawal_request_status");
		}
	}
}
