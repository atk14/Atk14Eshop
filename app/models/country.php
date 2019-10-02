<?php
class Country {

	protected $code;
	
	function __construct($code){
		$code = strtoupper($code);
		$this->code = $code;
	}

	/**
	 * For compatibility with a TableRecords bahaviour
	 */
	function GetInstanceById($code){
		if(is_array($code)){
			$out = [];
			foreach($code as $k => $c){
				$out[$k] = self::GetInstanceById($c);
			}
			return $out;
		}
		if(!$code){
			return null;
		}
		return new Country($code);
	}

	function isEuCountry(){
		return in_array($this->getCode(),[
      'AT', // Austria
      'BE', // Belgium
      'BG', // Bulgaria
      'CY', // Cyprus
      'CZ', // Czech Republic
      'DE', // Germany
      'DK', // Denmark
      'EE', // Estonia
      'EL', // Greece
      'ES', // Spain
      'FI', // Finland
      'FR', // France
      'HR', // Croatia
      'HU', // Hungary
      'IE', // Ireland
      'IT', // Italy
      'LU', // Luxembourg
      'LV', // Latvia
      'LT', // Lithuania
      'MT', // Malta
      'NL', // Netherlands
      'PL', // Poland
      'PT', // Portugal
      'RO', // Romania
      'SE', // Sweden
      'SI', // Slovenia
      'SK', // Slovakia
      'GB', // United Kingdom
		]);
	}

	function isCzechRepublic(){
		return $this->getCode()=="CZ";
	}

	function getCode(){
		return $this->code;
	}

	function getId(){
		return $this->getCode();
	}

	function getName(){
		$code = $this->getCode();
		$countries = CountryListLoader::Get();
		return isset($countries[$code]) ? $countries[$code] : $code;
	}

	function toString(){
		return (string)$this->getName();
	}

	function __toString(){ return $this->toString(); }
}
