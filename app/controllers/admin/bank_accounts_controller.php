<?php
class BankAccountsController extends AdminController {

	function index(){
		$this->page_title = _("List of bank accounts");

		$this->tpl_data["bank_accounts"] = BankAccount::FindAll();
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
