<?php
class OrderStatusesController extends AdminController {

	function index(){
		$this->page_title = _("Seznam všech stavů objednávek");

		$this->tpl_data["order_statuses"] = OrderStatus::FindAll();
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace stavu objednávky"),
		]);
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("order_status");
		}
	}
}
