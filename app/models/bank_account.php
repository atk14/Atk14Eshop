<?php
// TODO: Transform this into an ApplicationModel
class BankAccount {

	function getAccountNumber(){
		return SystemParameter::ContentOn("merchant.billing_information.bank_account.number");
	}

	function getIban(){
		return SystemParameter::ContentOn("merchant.billing_information.bank_account.iban");
	}

	function getSwiftBic(){
		return SystemParameter::ContentOn("merchant.billing_information.bank_account.swift_bic");
	}

	function getHolderName(){
		return SystemParameter::ContentOn("merchant.billing_information.bank_account.holder");
	}

	function getCurrencyId(){
		return $this->getCurrency()->getId();
	}

	function getCurrency(){
		return Currency::GetDefaultCurrency();
	}

}
