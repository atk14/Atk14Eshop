<?php
class AddingBankAccountMigration extends ApplicationMigration {

	function up(){
		global $ATK14_GLOBAL;

		$regions = [];
		foreach(Region::FindAll() as $region){
			$regions[$region->getCode()] = true;
		}

		$currencies = [];
		foreach(Currency::FindAll() as $currency){
			$currencies[] = $currency->getCode();
		}

		$values = [
			"code" => "default",
			"regions" => json_encode($regions),
			"currencies" => json_encode($currencies),
			"account_number" => SystemParameter::ContentOn("merchant.billing_information.bank_account.number"),
			"iban" => SystemParameter::ContentOn("merchant.billing_information.bank_account.iban"),
			"swift_bic" => SystemParameter::ContentOn("merchant.billing_information.bank_account.swift_bic"),
			"holder_name" => SystemParameter::ContentOn("merchant.billing_information.bank_account.holder"),
			"bank_name" => SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.name"),
			"bank_address_street" => SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.address.street"),
			"bank_address_street2" => SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.address.street2"),
			"bank_address_city" => SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.address.city"),
			"bank_address_state" => SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.address.state"),
			"bank_address_zip" => SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.address.zip"),
			"bank_address_country" => SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.address.country"),
		];

		foreach($ATK14_GLOBAL->getSupportedLangs() as $l){
			$values["name_$l"] = SystemParameter::ContentOn("merchant.billing_information.bank_account.bank.name");
		}

		$bank_account = BankAccount::CreateNewRecord($values);

		foreach(SystemParameter::FindAll("code LIKE 'merchant.billing_information.bank_account%'") as $sp){
			$this->logger->info("destroying SystemParameter ".$sp->getCode());
			$sp->destroy();
		}
	}
}
