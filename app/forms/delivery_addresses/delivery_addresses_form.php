<?php
class DeliveryAddressesForm extends ApplicationForm {
	
	function set_up(){
		$this->_add_firstname_lastname();
		$this->_add_company_fields(["add_company_number" => false, "add_vat_id" => false]);

		$this->_add_address_fields([
			"allowed_countries" => Region::GetDeliveryCountriesFromActiveRegions(),
		]);
		$this->_add_phone();
	}

	function clean(){
		list($err,$d) = parent::clean();

		$keys = is_array($d) ? array_keys($d) : [];

		return [$err,$d];
	}
}
