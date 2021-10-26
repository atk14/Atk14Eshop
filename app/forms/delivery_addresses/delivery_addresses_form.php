<?php
class DeliveryAddressesForm extends ApplicationForm {
	
	function set_up(){
		$this->_add_firstname_lastname();
		$this->_add_company_fields(["add_company_number" => false, "add_vat_id" => false]);
		$this->_add_address_fields([
			"add_address_state" => false, // at the moment we do not want to add address_state field
			"only_allowed_countries_for_delivery" => true
		]);
		$this->_add_phone();
	}

	function clean(){
		list($err,$d) = parent::clean();

		$keys = is_array($d) ? array_keys($d) : [];

		return [$err,$d];
	}
}
