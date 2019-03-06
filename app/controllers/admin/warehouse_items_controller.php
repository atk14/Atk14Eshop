<?php
class WarehouseItemsController extends AdminController {

	function index(){
		$this->page_title = _("Warehouse status");
	}

	function _before_filter(){
		$this->_find("warehouse","warehouse_id");
	}
}
