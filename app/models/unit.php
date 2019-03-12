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
	function getUnitPriceRoundingPrecision(){
		// Standardne se zaokrouhluje na 2 mista
		// a prida se k tomu pocet nul u nasobku pro zobrazeni.
		// Tim dosahneme u cm: 2 + 2 -> 4 des. mista, coz by odpovidalo 2 mistum u metru.
		// Standardni hodnota by mela vychazet z pouzite meny.
		$precision = 2 + log10($this->getDisplayUnitMultiplier());
		return (int)$precision;
	}
	
	/**
	 *
	 *	echo $pc; // "cm" nebo "ks"
	 */
	function toString(){ return $this->getUnitLocalized(); }	
}
