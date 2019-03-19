<?php
class EditForm extends VouchersForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["voucher_id"]) && Voucher::FindFirst("voucher_id=:voucher_id AND id!=:id",[":voucher_id" => $d["voucher_id"], ":id" => $this->controller->voucher])){
			$this->set_error("voucher_id",_("Stejný kód má jiný slevový kupón"));
		}

		return [$err,$d];
	}
}
