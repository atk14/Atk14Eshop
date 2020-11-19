<?php
class Unit extends ApplicationModel implements Translatable {

	static function GetTranslatableFields(){ return ["unit_localized", "display_unit_localized"]; }

	function getUnitLocalized(){
		$out = parent::getUnitLocalized(); // "ks"
		if(!$out){ $out = $this->getUnit(); } // "pcs"
		return $out;
	}

	function getDisplayUnitLocalized(){
		$out = parent::getDisplayUnitLocalized(); // "m"
		if(!$out){ $out = $this->getDisplayUnit(); } // "m"
		return $out;
	}

	/**
	 * Na kolik des. mist se ma zaokrouhlovat jednotkova cena produktu, ktery ma tuto jednotku?
	 *
	 *	echo $pcs->getUnitPriceRoundingPrecision(); // 2
	 *	echo $cm->getUnitPriceRoundingPrecision(); // 4
	 */
	function getUnitPriceRoundingPrecision($currency = null){
		if(is_null($currency)){
			$currency = Currency::GetDefaultCurrency();
		}

		// Standardne se zaokrouhluje na 2 mista
		// a prida se k tomu pocet nul u nasobku pro zobrazeni.
		// Tim dosahneme u cm: 2 + 2 -> 4 des. mista, coz by odpovidalo 2 mistum u metru.
		// Standardni hodnota by mela vychazet z pouzite meny.
		$precision = $currency->getDecimals() + ceil(log10($this->getDisplayUnitMultiplier()));
		return (int)$precision;
	}

	/**
	 * Returns decimal places suitable for displaying quantity
	 *
	 *	// e.g. unit cm
	 * 	echo $cm->getDisplayUnitMultiplier(); // 100
	 * 	echo $cm->getDisplayUnit(); // m
	 *	echo $cm->getDisplayQuantityPrecision(); // 2
	 *
	 *	{* in a template *}
	 * 	amount: {($item->getAmount()/$unit->getDisplayUnitMultiplier())|format_number:$unit->getDisplayQuantityPrecision()} {$unit->getDisplayUnit()}
	 *
	 *	... for 120 cm it renders
	 *	amount: 1,20 m
	 */
	function getDisplayQuantityPrecision(){
		return log10($this->getDisplayUnitMultiplier()); // 0, 1, 2...
	}

	function getStockcountDisplayLimit(){
		// TODO: store limits into database
		$limits = [
			"pcs" => 10,
			"cm" => 1000,
			"g" => 10000,
		];

		$unit = $this->getUnit();
		return isset($limits[$unit]) ? $limits[$unit] : 10000;
	}
	
	/**
	 *
	 *	echo $pc; // "cm" nebo "ks"
	 */
	function toString(){ return $this->getUnitLocalized(); }	
}
