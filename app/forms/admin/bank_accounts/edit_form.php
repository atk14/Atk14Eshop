<?php
class EditForm extends BankAccountsForm {

	function set_up(){
		parent::set_up();

		if($this->controller->bank_account->getCode()==="default"){
			$this->disable_fields([
				"active",
				"code"
			]);
		}
	}
}
