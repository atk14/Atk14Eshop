<?php
defined("DEFAULT_REGION") || define("DEFAULT_REGION","CZ");

class Region extends ApplicationModel implements Translatable, Rankable {

	static function GetTranslatableFields(){ return array("application_name", "application_long_name"); }

	static function GetInstances(){
		static $regions;
		if(!$regions){
			$regions = Region::FindAll(["order_by" => "id", "use_cache" => true]);
		}
		return $regions;
	}

	static function GetRegionByCode($code){
		foreach(self::GetInstances() as $r){
			if($r->getCode()==$code){
				return $r;
			}
		}
	}

	static function GetDefaultRegion(){
		return self::GetRegionByCode(DEFAULT_REGION);
	}

	static function GetRegionByDomain($domain){
		foreach(self::GetInstances() as $r){
			if(in_array($domain,$r->getDomains())){
				return $r;
			}
		}
	}

	static function GetDeliveryCountriesFromallRegions(){
		$all_allowed_countries = [];
		foreach(Region::GetInstances() as $region){
			$dcs = $region->getDeliveryCountries();
			$all_allowed_countries += array_combine($dcs,$dcs);
		}
		$all_allowed_countries = array_values($all_allowed_countries);
		return $all_allowed_countries;
	}

	function setRank($rank){
		$this->_setRank($rank);
	}

	function getApplicationName(){
		$out = parent::getApplicationName();
		if($out){ return $out; }
		return ATK14_APPLICATION_NAME;
	}

	function getApplicationLongName(){
		$out = parent::getApplicationLongName();
		if($out){ return $out; }
		return ATK14_APPLICATION_NAME;
	}

	function getEmail(){
		$out = $this->g("email");
		if($out){ return $out; }
		return DEFAULT_EMAIL;
	}

	function getDomains(){
		return (array)json_decode($this->g("domains"),true);
	}

	function getDefaultDomain(){
		if($domains = $this->getDomains()){
			return $domains[0];
		}
	}

	function getDefaultUrl(){
		if($domain = $this->getDefaultDomain()){
			return "http://$domain/";
		}
	}

	/**
	 *	
	 *	$sk->getAppropriateDomain($request->getHttpHost()); // null or "www.domlatok.sk"
	 *
	 *	$sk->getAppropriateDomain("www.dumlatek.cz"); // "www.domlatok.sk"
	 *	$sk->getAppropriateDomain("dumlatek.cz"); // "domlatok.sk"
	 */
	function getAppropriateDomain($current_domain){
		$current_region = Region::GetRegionByDomain($current_domain);
		if(!$current_region){
			return null;
		}
		$current_domains = $current_region->getDomains();
		$i = array_search($current_domain,$current_domains);

		$domains = $this->getDomains();
		return isset($domains[$i]) ?  $domains[$i] : $this->getDefaultDomain();
	}

	/**
	 *
	 * @return Lang[]
	 */
	function getLanguages(){
		$codes = (array)json_decode($this->g("languages"),true);

		$langs = Lang::GetInstances();

		$out = array();
		foreach($codes as $code){
			foreach($langs as $lang){
				if($lang->getLang()==$code){
					$out[] = $lang;
					break;
				}
			}
		}
		return $out;
	}

	/**
	 *
	 * echo 
	 *
	 * @return Lang
	 */
	function getDefaultLanguage(){
		if($langs = $this->getLanguages()){
			return $langs[0];
		}
	}

	/**
	 * @return Currency[]
	 */
	function getCurrencies(){
		$codes = json_decode($this->g("currencies"),true);

		$currencies = Currency::FindAll("code IN :codes",[":codes" => $codes]);

		$out = [];
		foreach($codes as $code){
			foreach($currencies as $c){
				if($c->getCode()==$code){
					$out[] = $c;
					break;
				}
			}
		}

		return $out;
	}

	/**
	 *
	 * @return Currency
	 */
	function getDefaultCurrency(){
		if($currencies = $this->getCurrencies()){
			return $currencies[0];
		}
	}

	/**
	 *
	 *	var_dump($region->getDeliveryCountries()); // ["CZ"]
	 *
	 * @return string[]
	 */
	function getDeliveryCountries(){
		return (array)json_decode($this->g("delivery_countries"),true);
	}

	function toString(){
		return (string)$this->getCode();
	}
}
