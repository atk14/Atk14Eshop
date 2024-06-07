<?php
class Region extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return array("name", "short_name", "application_name", "application_long_name"); }

	static function GetAllInstances(){
		static $regions;
		if(!$regions || TEST){
			$regions = Region::FindAll(["use_cache" => true]);
		}
		return $regions;
	}

	static function GetInstances(){
		$file = $line = "???";
		$ar = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT,1);
		if($ar){
			$file = $ar[0]["file"];
			$line = $ar[0]["line"];
		}
		trigger_error(sprintf("Method Region::GetInstances() is deprecated, use Region::GetAllInstances() in %s on line %d",$file,$line));
		return self::GetAllInstances();
	}

	static function GetActiveInstances(){
		$regions = self::GetAllInstances();
		$regions = array_filter($regions,function($region){ return $region->isActive(); });
		$regions = array_values($regions);
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
		foreach(self::GetActiveInstances() as $r){
			if(in_array($domain,$r->getDomains())){
				return $r;
			}
		}
	}

	/**
	 * @return string[]
	 */
	static function GetDeliveryCountriesFromAllRegions(){
		$regions = self::GetAllInstances();
		return self::_MergeCountries($regions,"getDeliveryCountries");
	}

	/**
	 * @return string[]
	 */
	static function GetDeliveryCountriesFromActiveRegions(){
		$regions = self::GetActiveInstances();
		return self::_MergeCountries($regions,"getDeliveryCountries");
	}

	/**
	 * @return string[] || NULL
	 */
	static function GetInvoiceCountriesFromAllRegions(){
		$regions = self::GetAllInstances();
		return self::_MergeCountries($regions,"getInvoiceCountries");
	}

	/**
	 * @return string[] || NULL
	 */
	static function GetInvoiceCountriesFromActiveRegions(){
		$regions = self::GetActiveInstances();
		return self::_MergeCountries($regions,"getInvoiceCountries");
	}

	/**
	 * @return string
	 */
	static function GetDefaultValueForRegionsColumn(){
		$out = [];
		foreach(self::GetAllInstances() as $region){
			$out[$region->getCode()] = true;
		}
		return json_encode($out);
	}

	static protected function _MergeCountries($regions,$method){
		$all_allowed_countries = [];
		foreach($regions as $region){
			$countries = $region->$method();
			if(is_null($countries)){
				return null; // null means no limit
			}
			$all_allowed_countries += array_combine($countries,$countries);
		}
		$all_allowed_countries = array_values($all_allowed_countries);
		return $all_allowed_countries;
	}

	function setRank($rank){
		$this->_setRank($rank);
	}

	function isActive() {
		return $this->getActive();
	}

	function getShortName($lang = null){
		$short_name = parent::getShortName($lang);
		if(strlen((string)$short_name)){
			return $short_name;
		}
		return parent::getName($lang);
	}

	/**
	 * Returns either short name or it creates shortcut automatically from name
	 */
	function getShortcut($lang = null){
		$short_name = parent::getShortName($lang);
		if(strlen((string)$short_name)){
			return $short_name;
		}
		$name = new String4(parent::getName($lang));
		return $name->truncate(3,["omission" => ""])->upper()->trim()->toString();
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
		return (array)json_decode((string)$this->g("domains"),true);
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
	function getLanguages($options = array()){
		$options += array(
			"as_objects" => true,
		);

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

		if(!$options["as_objects"]){
			$out = array_map(function($lang){ return $lang->getId(); },$out);
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
	 *	if(is_null($region->getInvoiceCountries())){
	 *		// without limits
	 *	}
	 *
	 * @return string[] || NULL
	 */
	function getInvoiceCountries(){
		if($this->g("invoice_countries")){
			return (array)json_decode($this->g("invoice_countries"),true);
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
			0 === $this->dbmole->selectInt("SELECT COUNT(*) FROM (SELECT id FROM (SELECT id FROM baskets WHERE region_id=:region LIMIT 1)q1 UNION SELECT id FROM (SELECT id FROM orders WHERE region_id=:region)q2)q",[":region" => $this]);
	}

	function toString(){
		return (string)$this->getCode();
	}
}
