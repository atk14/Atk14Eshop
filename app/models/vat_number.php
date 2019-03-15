<?php
/**
 * Obalovaci trida pro DIC
 *
 * Obsahuje priznak, zda je toto DIC zvalidovano v systemu VIES (http://ec.europa.eu/taxation_customs/vies/vatResponse.html)
 *
 * Objekt teto tridy vraci formularove policko VatNumberField
 *
 *	$vat_number = new VatNumberWithValidation(["vat_number" => "CZ123456", "is_valid_for_cross_border_transactions_within_eu" => true]);
 *
 */
class VatNumber extends Dictionary{

	function __construct($values = []){
		$values += [
			"vat_number" => "",
			"is_valid_for_cross_border_transactions_within_eu" => null,
		];

		parent::__construct($values);
	}

	static function BlankVatNumber(){
		return new self(["vat_number" => "", "is_valid_for_cross_border_transactions_within_eu" => null]);
	}

	function getVatNumber(){
		return $this["vat_number"];
	}

	/**
	 * Bylo toto DIC overene v systemu VIES VAT number validation?
	 *
	 * VIES VAT number validation: http://ec.europa.eu/taxation_customs/vies/vatResponse.html
	 *
	 * Vystup:
	 * - true: toto je validini DIC v systemu VIES
	 * - false: toto je nevalidni DIC v systemu VIES
	 * - null: validace selhala nebo nebyla provedena
	 */
	function isValidForCrossBorderTransactionsWithinEu(){
		return $this["is_valid_for_cross_border_transactions_within_eu"];
	}

	function getCountryCode(){
		return substr($this->getVatNumber(),0,2);
	}

	function getCountry(){
		return new Country($this->getCountryCode());
	}

	function toString(){
		return (string)$this->getVatNumber();
	}

	function __toString(){
		return $this->toString();
	}
}
