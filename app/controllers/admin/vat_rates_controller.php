<?php
class VatRatesController extends AdminController {

	function index(){
		$this->page_title = _("List of VAT rates");
		$this->tpl_data["vat_rates"] = VatRate::FindAll();
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
