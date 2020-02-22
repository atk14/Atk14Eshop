<?php
class UsersForm extends ApplicationForm{

	function _add_basic_account_fields(){
		$this->add_field("gender_id", new GenderField(array(
			"label" => _("Oslovení"),
		)));

		$this->_add_firstname_lastname();
		$this->_add_email();

		$this->_add_company_fields(["enable_vat_id_validation" => false]);
		$this->_add_address_fields([
			"add_note" => false,
		]);

		$this->_add_phone();
	}

	function _add_password_fields(){
		$this->add_field("password", new PasswordField(array(
			"label" => _("Password"),
			"max_length" => 255,
		)));

		$this->add_field("password_repeat", new PasswordField(array(
			"label" => _("Password (repeat)"),
			"max_length" => 255,
		)));
	}

	function clean(){
		list($err,$d) = parent::clean();
		$keys = array_keys($d);

		if(in_array("company",$keys)){
			if(isset($d["company_number"]) && $d["company_number"] && !strlen($d["company"])){
				$this->set_error("company_number",_("IČ zadávejte pouze v případě, že je vyplněn název společnosti"));
			}
		}

		if(
			isset($d["password"]) &&
			isset($d["password_repeat"]) &&
			$d["password"]!=$d["password_repeat"]
		){
			$this->set_error("password_repeat",_("Password doesn't match"));
		}
		unset($d["password_repeat"]);

		$this->_clean_vat_id_and_country();

		return array($err,$d);
	}
}
