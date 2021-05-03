<?php
class BankAccountsForm extends AdminForm {
	
	function set_up(){
		$this->add_translatable_field("name",new CharField(array(
			"label" => _("Name of the bank account"),
			"max_length" => 255,
		)));

		$this->add_field("account_number", new CharField([
			"label" => _("Bank account number"),
			"max_length" => 255,
		]));

		$this->add_active_field([
			"label" => _("Is the bank account active?")
		]);

		$this->add_field("regions", new RegionsField([
			"label" => _("Regions where the account is applicable"),
			"json_encode" => true,
			"initial" => "__all__",
		]));

		$this->add_field("currencies", new CurrenciesField([
			"label" => _("Currencies"),
		]));

		$this->add_field("iban", new CharField([
			"label" => "IBAN",
			"max_length" => 255,
			"required" => false,
		]));
		
		$this->add_field("swift_bic", new CharField([
			"label" => "SWIFT/BIC",
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_field("holder_name", new CharField([
			"label" => _("Bank account holder"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_field("bank_name", new CharField([
			"label" => _("The name of the bank where the account is held"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_field("bank_address_street", new CharField([
			"label" => _("Bank address: Street"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_field("bank_address_street2", new CharField([
			"label" => _("Bank address: Street (2nd line)"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_field("bank_address_city", new CharField([
			"label" => _("Bank address: City"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_field("bank_address_state", new CharField([
			"label" => _("Bank address: State / Province / Region"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_field("bank_address_zip", new CharField([
			"label" => _("Bank address: ZIP"),
			"max_length" => 255,
			"required" => false,
		]));
	
		$this->add_field("bank_address_country", new CountryField([
			"label" => _("Bank address: Country"),
			"max_length" => 255,
			"required" => false,
		]));

		$this->add_code_field();
	}
}
