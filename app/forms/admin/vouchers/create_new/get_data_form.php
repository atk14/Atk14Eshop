<?php
class GetDataForm extends VouchersForm {

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["voucher_code"]) && Voucher::FindFirst("voucher_code",$d["voucher_code"])){
			$this->set_error("voucher_code",_("Stejný kód má jiný slevový kupón"));
		}

		return [$err,$d];
	}
}
