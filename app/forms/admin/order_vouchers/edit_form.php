<?php
class EditForm extends OrderVouchersForm {

	function set_up(){
		parent::set_up();
		$this->fields["voucher_id"]->disabled = true;
	}
}
