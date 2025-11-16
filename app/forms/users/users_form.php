<?php
class UsersForm extends ApplicationForm{

	function _add_basic_account_fields(){
		if(CONSIDER_GENDER_ID_FIELD){
			$this->_add_gender_id_field();
		}

		$this->_add_firstname_lastname();
		$this->_add_email();

		// Pro Slovensko je fomrular spec. potuneny,
		// proto ho moc nechceme kombinovat s jinymi staty

		$allowed_countries = $current_region_allowed_countries = $this->controller->current_region->getInvoiceCountries();
		/*
		// Tady zahrnujeme vsechny zeme + pripadne odstranujeme Slovensko
		// TODO: Mozna to ani nepotrebujeme
		if($allowed_countries!=["SK"]){
			$allowed_countries = Region::GetInvoiceCountriesFromActiveRegions();
			if($allowed_countries && in_array("SK",$allowed_countries)){
				$allowed_countries = array_filter($allowed_countries,function($country){ return $country!=="SK"; });
				$allowed_countries = array_values($allowed_countries);
			}
		}
		*/

		$this->_add_company_fields(["enable_vat_id_validation" => false]);
		$this->_add_address_fields([
			"add_note" => false,
			"allowed_countries" => $allowed_countries,
		]);

		/*
		// Vzhledem k zakomentovani kodu vyse, toto taky nepotrebujeme
		if($current_region_allowed_countries && sizeof($current_region_allowed_countries)==1){
			$this->set_initial("address_country",$current_region_allowed_countries[0]);
		}
		*/

		$this->_add_phone();

		if($allowed_countries==["SK"]){
			$this->tune_for_slovakia();
		}
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
			$d["password"]!==$d["password_repeat"]
		){
			$this->set_error("password_repeat",_("Password doesn't match"));
		}
		unset($d["password_repeat"]);

		$this->_clean_vat_id_and_country();

		return array($err,$d);
	}
}
