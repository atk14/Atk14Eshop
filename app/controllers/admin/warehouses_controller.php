<?php
class WarehousesController extends AdminController {

	function index(){
		$this->page_title = _("Warehouses");
		$this->tpl_data["warehouses"] = Warehouse::FindAll(["use_cache" => true]);
	}

	function create_new(){
		$this->_create_new();
	}

	function edit(){
		$this->_edit();
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}
}
