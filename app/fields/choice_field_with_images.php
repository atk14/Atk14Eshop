<?php
Atk14Require::Helper("modifier.display_price");
class ChoiceFieldWithImages extends ChoiceField {

	function __construct($options = []){
		$options += [
			"widget" => new SelectWithImages($options),
			"display_prices" => true,
			"display_empty_offer" => false,
			"basket" => null,
			"required" => true,
			"initial" => null,
		];

		$basket = $options["basket"];

		$options += [
			"currency" => $basket ? $basket->getCurrency() : Currency::GetDefaultCurrency(),
			"region" => $basket ? $basket->getRegion() : Region::GetDefaultRegion(),
			"free_shipping" => $basket ? $basket->freeShipping() : false,
		];
		$options += [
			"currency_rate" => CurrencyRate::GetCurrencyRate($options['currency'])
		];

		$choices = $this->getChoices($options);
		if($options['display_empty_offer']) {
			$choices = [ null => $options['display_empty_offer'] ] + $choices;
		}
		$options["choices"] = $choices;

		if(sizeof($choices)==1 && $options["required"]){
			$keys = array_keys($choices);
			$options["initial"] = $keys[0];
		}

		parent::__construct($options);
	}
}
