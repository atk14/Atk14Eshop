<?php
defined("DEFAULT_CURRENCY") || define("DEFAULT_CURRENCY","CZK");

class Currency extends ApplicationModel{

	use TraitCodebook;

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
	 *	$rate = $eur->getRate(); // e.g. 26.5
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

	function roundPrice($price,$mode = PHP_ROUND_HALF_UP){
		if(!is_null($price)){
			return round($price,$this->getDecimals(),$mode);
		}
	}

	/**
	 *
	 * 	$pcs = Unit::FindByUnit("pcs");
	 *	$pcs->getDisplayUnitMultiplier(); // 1
	 * 	$price = $currency->roundUnitPrice(1.23456,$pcs); // 1.23
	 *
	 *	$cm = Unit::FindByUnit("cm");
	 *	$cm->getDisplayUnitMultiplier(); // 100
	 *	$price = $currency->roundUnitPrice(1.23456,$cm); // 1.2346
	 */
	function roundUnitPrice($price,$unit,$mode = PHP_ROUND_HALF_UP){
		if(is_null($price)){ return null; }

		$decimals = $unit->getUnitPriceRoundingPrecision($this);
		return round($price,$decimals,$mode);
	}

	function roundSummaryPrice($price,$mode = PHP_ROUND_HALF_UP){
		if(!is_null($price)){
			return round($price,$this->getDecimalsSummary(),$mode);
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
