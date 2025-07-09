<?php
class SpecialPricelistsController extends AdminController {

	function index(){
		$this->page_title = _("Special price lists");
		$this->tpl_data["special_pricelists"] = SpecialPricelist::FindAll();
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
