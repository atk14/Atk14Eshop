<?php
defined("DEFAULT_CURRENCY") || define("DEFAULT_CURRENCY","CZK");

class Currency extends ApplicationModel{

	static function GetInstanceById($id, $options=[]) {
		$options += ['use_cache' => true];
		if($options['use_cache']) {
			#HACK - prefetch all instances
			self::GetInstanceByCode(null);
		}
		return parent::GetInstanceById($id, $options);
	}

	/**
	 *	$currency = Currency::GetInstanceByCode("EUR");
	 */
	static function GetInstanceByCode($code){
		static $instances;

		if(!$instances){
			$instances = [];
			foreach(Currency::FindAll(["use_cache" => true]) as $c){
				$instances[$c->getCode()] = $c;
			}
		}

		$code = (string)$code;
		return isset($instances[$code]) ? $instances[$code] : null;
	}

	/**
	 *	echo Currency::GetCurrentRate("EUR");
	 */
	static function GetCurrentRate($currency) {
		if(is_numeric($currency)){
			$cur = Cache::Get("Currency",$currency);
		}else{
			$cur = self::GetInstanceByCode($currency);
		}
		return $cur->getRate();
	}

	static function GetDefaultCurrency(){
		return self::GetInstanceByCode(DEFAULT_CURRENCY);
	}

	/**
	 * Returns rate of this currency to the default currency
	 *
	 * Obviously the default currency has rate 1.0
	 *
	 *	$rate = $eur->getRate();
	 *	$rate = $eur->getRate("2017-09-27");
	 *	$rate = $eur->getRate("2017-09-27 12:33:33");
	 *	$rate = $eur->getRate(time());
	 *
	 * @return float
	 */
	function getRate($date = null){
		return CurrencyRate::GetCurrencyRate($this,$date);
	}

	/**
	 *
	 *	echo $currency->getCode(); // "CZK"
	 */
	function getCode(){
		// v nekterych aplikacich policko currencies.code neexistuje a misto toho se pouziva primo id
		return $this->hasKey("code") ? $this->g("code") : $this->getId();
	}

	/**
	 * echo $currency->getSymbol(); // "Kč" nebo "EUR"
	 */
	function getSymbol(){
		$tr = array(
			"CZK" => _("Kč"),
		);
		$code = $this->getCode();
		return isset($tr[$code]) ? $tr[$code] : $code;
	}

	function roundPrice($price){
		if(!is_null($price)){
			return round($price,$this->getDecimals());
		}
	}

	function roundSummaryPrice($price){
		if(!is_null($price)){
			return round($price,$this->getDecimalsSummary());
		}
	}

	function isDefaultCurrency(){
		$dc = self::GetDefaultCurrency();
		return $this->getId()===$dc->getId();
	}
	
	/**
	 * echo "$currency"; // EUR nebo CZK
	 */
	function toString(){
		return (string)$this->getCode();
	}
}
