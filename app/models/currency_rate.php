<?php
class CurrencyRate extends ApplicationModel{

	static function CreateNewRecord($values,$options = array()){
		$values += array(
			"rate_date" => now(),
		);

		return parent::CreateNewRecord($values,$options);
	}

	function getCurrency(){
		return Cache::Get("Currency",$this->getCurrencyId());
	}

	/**
	 * Returns rate of the given currency to the default currency
	 *
	 * Obviously the default currency has rate 1.0
	 *
	 *	$rate = CurrencyRate::GetCurrencyRate($currency);
	 *	$rate = CurrencyRate::GetCurrencyRate("CZK");
	 *	$rate = CurrencyRate::GetCurrencyRate(1);
	 *
	 * @return float
	 */
	static function GetCurrencyRate($currency,$date = null){
		static $time,$CACHE = array();

		if(!is_object($currency)){
			$currency = is_numeric($currency) ? Cache::Get("Currency",$currency) : Currency::GetInstanceByCode($currency);
		}

		if(!isset($time)){ $time = time(); }
		$id = $currency->getId();
		if(!isset($CACHE[$id])){ $CACHE[$id] = array(); }

		if(!$date){ $date = $time; }
		if(is_numeric($date)){ $date = date("Y-m-d H:i:s",$date); }

		if(!isset($CACHE[$id][$date])){
			$dbmole = self::GetDbmole();
			$rate = $dbmole->selectFloat("SELECT rate FROM currency_rates WHERE currency_id=:id AND rate_date<=:rate_date ORDER BY rate_date DESC LIMIT 1",array(
				":id" => $currency,
				":rate_date" => $date,
			));
			if(is_null($rate)){ $rate = 1.0; }
			$CACHE[$id][$date] = $rate;
		}

		return $CACHE[$id][$date];
	}
}
