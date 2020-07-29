<?php
class VoucherField extends CharField {

	function __construct($options = []){
		$options += [
			"null_empty_output" => true,
			"max_length" => 50,
			"initial_value_is_id" => false,
		];

		$this->initial_value_is_id = $options["initial_value_is_id"];
		unset($options["initial_value_is_id"]);

		parent::__construct($options);

		$this->update_message("no_such_voucher",_("Toto není správný slevový kupón"));
	}


	function format_initial_data($value){
		if($this->initial_value_is_id){
			return Voucher::FindById($value);
		}
		return $value;
	}

	function clean($value){
		list($err,$value) = parent::clean($value);
		if(isset($err) || is_null($value)){ return [$err, $value]; }

		$value = Translate::Upper($value);
		$voucher = Voucher::FindByVoucherCode($value);
		if(!$voucher){
			return [$this->messages["no_such_voucher"],null];
		}
		
		return [null,$voucher];
	}
}
