<?php
// DIC toho, kdo se pta...
defined("VIES_REQUESTOR_VAT_NUMBER") || define("VIES_REQUESTOR_VAT_NUMBER","");

class MyVies extends \DragonBe\Vies\Vies {

	public function validateVat(
		string $countryCode,
		string $vatNumber,
		string $requesterCountryCode = "",
		string $requesterVatNumber = "",
		string $traderName = "",
		string $traderCompanyType = "",
		string $traderStreet = "",
		string $traderPostcode = "",
		string $traderCity = ""
	): DragonBe\Vies\CheckVatResponse {
		if(!$requesterCountryCode && !$requesterVatNumber && VIES_REQUESTOR_VAT_NUMBER){
			$requesterCountryCode = substr(VIES_REQUESTOR_VAT_NUMBER,0,2);
			$requesterVatNumber = substr(VIES_REQUESTOR_VAT_NUMBER,2);
		}

		return parent::validateVat($countryCode, $vatNumber, $requesterCountryCode, $requesterVatNumber, $traderName, $traderCompanyType, $traderStreet, $traderPostcode, $traderCity);
	}
}
