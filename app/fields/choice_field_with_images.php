<?php
Atk14Require::Helper("modifier.display_price");
class ChoiceFieldWithImages extends ChoiceField {

	function __construct($options = []){
		$options += [
			"widget" => new SelectWithImages($options),
			"display_prices" => true,
			"display_empty_offer" => false,
			"basket" => null,
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
		parent::__construct($options);
	}
}
