<?php
class EditForm extends VouchersForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["voucher_code"]) && Voucher::FindFirst("voucher_code=:voucher_code AND id!=:id",[":voucher_code" => $d["voucher_code"], ":id" => $this->controller->voucher])){
			$this->set_error("voucher_code",_("Stejný kód má jiný slevový kupón"));
		}

		return [$err,$d];
	}
}
