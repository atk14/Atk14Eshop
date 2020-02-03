<?php
// Online validace DIC z EU
// V teto tride je vyrazen validator DIC v CZ, ktery nefunguje pro DIC CZ27589111

// DIC toho, kdo se pta...
defined("VIES_REQUESTOR_VAT_NUMBER") || define("VIES_REQUESTOR_VAT_NUMBER","");

class MyVies extends \DragonBe\Vies\Vies {

	public function validateVatSum($countryCode, $vatNumber, $requesterCountryCode = null, $requesterVatNumber = null) {
		if(is_null($requesterCountryCode) && is_null($requesterVatNumber) && VIES_REQUESTOR_VAT_NUMBER){
			$requesterCountryCode = substr(VIES_REQUESTOR_VAT_NUMBER,0,2);
			$requesterVatNumber = substr(VIES_REQUESTOR_VAT_NUMBER,2);
		}

		if($countryCode=="CZ"){
			return true;
		}
		return parent::validateVatSum($countryCode, $vatNumber, $requesterCountryCode, $requesterVatNumber);
	}
}
