<?php
/**
 * Vystupem tohoto pole je objekt typu VatNumber
 */
class VatNumberField extends RegexField{

	function __construct($options = []){
		$options += [
			"enable_validation" => false, // zapne validaci DIC v systemu VIES: http://ec.europa.eu/taxation_customs/vies/vatResponse.html;
		];
		$this->enable_validation = $options["enable_validation"];
		unset($options["enable_validation"]);

		parent::__construct('/^[A-Z]{2}\d{8,10}$/',$options);
		
		$this->update_messages(array(
			"invalid" => _("DIČ není zadáno správně"),
		));
	}

	function clean($value){
		$value = trim($value);
		$value = strtoupper($value); // "cz12345678" -> "CZ12345678"

		$value = preg_replace('/\s/','',$value); // "CZ 12345678" -> "CZ12345678"

		list($err,$value) = parent::clean($value);

		if(!$value){
			if(is_null($err)){
				$value = new VatNumber(["vat_number" => "", "is_valid_for_cross_border_transactions_within_eu" => null]);
			}
			return [$err,$value];
		}

		if(!extension_loaded("soap")){
			trigger_error("Exception soap is not loaded");
			$value = new VatNumber(["vat_number" => $value, "is_valid_for_cross_border_transactions_within_eu" => null]);
			return [$err,$value];
		}

		$vies = new MyVies();
		$value = $vies->filterVat($value); // tady je dalsi filtrace podivnych znaku

		if($this->enable_validation){
			//$vies = new \DragonBe\Vies\Vies();

			$is_valid = null;
			$is_alive = null;

			//
			try {
				$is_alive = $vies->getHeartBeat()->isAlive();
			} catch(Exception $e){
				// hmmm... 
			}
			if(!$is_alive){
				trigger_error('\DragonBe\Vies\Vies: service is not available at the moment, failed to validate VAT number '.$value);
			}

			if($is_alive)	{
				$countryCode = substr($value,0,2);
				$vatNumber = substr($value,2);

				try {
					$result = $vies->validateVat($countryCode, $vatNumber); // - Validation routine worked as expected.
					$is_valid = $result->isValid();
				} catch (DragonBe\Vies\ViesServiceException $e) {
					trigger_error('\DragonBe\Vies\Vies: online validation temporarily failed on VAT number '.$value);
					// Temporary error...
					// do nothing
				} catch (\DragonBe\Vies\ViesException $e) {
					// invalid_country_code; just do nothing
				}
			}

			$value = new VatNumber(["vat_number" => $value, "is_valid_for_cross_border_transactions_within_eu" => $is_valid]);

		}else{

			$value = new VatNumber(["vat_number" => $value, "is_valid_for_cross_border_transactions_within_eu" => null]);

		}

		return [$err,$value];
	}
}
