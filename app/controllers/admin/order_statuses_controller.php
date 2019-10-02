<?php
class OrderStatusesController extends AdminController {

	function index(){
		$this->page_title = _("Seznam všech stavů objednávek");

		$this->tpl_data["order_statuses"] = OrderStatus::FindAll(["order_by" => "id"]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace stavu objednávky"),
		]);
	}
}
