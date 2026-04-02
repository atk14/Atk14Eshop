<?php
class PricelistsController extends AdminController {

	function index(){
		$this->page_title = _("Price lists");
		$this->tpl_data["pricelists"] = Pricelist::FindAll();
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
