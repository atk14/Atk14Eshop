<?php
class Region extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return array("name", "application_name", "application_long_name"); }

	static function GetInstances(){
		static $regions;
		if(!$regions){
			$regions = Region::FindAll(["order_by" => "id", "use_cache" => true]);
		}
		return $regions;
	}

	static function GetRegionByCode($code){
		return self::GetInstanceByCode($code);
	}

	static function GetDefaultRegion(){
		defined("DEFAULT_REGION") || define("DEFAULT_REGION","DEFAULT");
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
		($out = parent::getApplicationName()) ||
		($out = SystemParameter::ContentOn("app.name.short")) ||
		($out = ATK14_APPLICATION_NAME);
		return $out;
	}

	function getApplicationLongName(){
		($out = parent::getApplicationLongName()) ||
		($out = SystemParameter::ContentOn("app.name")) ||
		($out = ATK14_APPLICATION_NAME);
		return $out;
	}

	function getEmail(){
		($out = $this->g("email")) ||
		($out = SystemParameter::ContentOn("app.contact.email")) ||
		($out = DEFAULT_EMAIL);
		return $out;
	}

	function getDomains(){
		return (array)json_decode($this->g("domains"),true);
	}

	function getDefaultDomain(){
		global $HTTP_REQUEST;
		if($domains = $this->getDomains()){
			return $domains[0];
		}
		if($HTTP_REQUEST->getHttpHost()){
			return $HTTP_REQUEST->getHttpHost();
		}
		return ATK14_HTTP_HOST;
	}

	function getDefaultUrl(){
		global $AKT14_GLOBAL, $HTTP_REQUEST;
		return Atk14Url::BuildLink([
			"namespace" => "",
			"controller" => "main",
			"action" => "index",
		],[
			"with_hostname" => $this->getDefaultDomain(),
			"ssl" => $HTTP_REQUEST->ssl(),
		]);
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

	function isDefaultRegion(){
		$def = self::GetDefaultRegion();
		return $this->getId()==$def->getId();
	}
	
	function isDeletable(){
		return
			!$this->isDefaultRegion() &&
			0 === $this->dbmole->selectInt("SELECT COUNT(*) FROM (SELECT id FROM baskets WHERE region_id=:region LIMIT 1 UNION SELECT id FROM orders WHERE region_id=:region)",[":region" => $this]);
	}

	function toString(){
		return (string)$this->getCode();
	}
}
