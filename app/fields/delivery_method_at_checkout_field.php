<?php
/**
 * Pole pro vyber dorucovaci metody behem dokoncovani objednavky
 */
class DeliveryMethodAtCheckoutField extends ChoiceFieldWithImages {

	function __construct($options = []){
		$options += [
			"basket" => null,
			"widget" => new DeliveryMethodAtCheckoutSelect($options),
		];

		$this->basket = $options["basket"];

		parent::__construct($options);
	}

	function getChoices($options) {
		list($delivery_methods,$payment_methods) = ShippingCombination::GetAvailableMethods4Basket($this->basket);

		$choices = [];
		foreach($delivery_methods as $o){
			$choices[$o->getId()] = new DeliveryMethodChoice($o, $options);
		}
		return $choices;
	}
}

class DeliveryMethodChoice {

	function __construct($dm, $options) {
		$this->options = $options;
		$this->dm = $dm;
	}

	function getLabel() {
		return $this->dm->getLabel();
	}

	function getHint() {
		return $this->dm->getDescription();
	}

	function getHintTitle() {
		return $this->dm->getTitle();
	}

	function getPrice() {
		$o = $this->dm;
		$rate = $this->options['currency_rate'];
		if ($this->options["display_prices"]!==true) {
			return null;
		}

		$basket = $this->options["basket"];

		$price = $o->getPriceInclVat();
		if(is_null($price)){
			return null;
		}

		$price = $price / $rate;

		$lowest_price  = $o->getLowestPriceInclVat() / $rate;
		$highest_price = $o->getHighestPriceInclVat() / $rate;
		if($price == 0.0 || $basket->freeShipping($this->dm)){
			$price = 0;
		}elseif($lowest_price!=$highest_price){
			$lowest = smarty_modifier_display_price($lowest_price,["format" => "plain", "currency" => $currency]);
			$highest = smarty_modifier_display_price($highest_price,["format" => "plain", "currency" => $currency]);
			//$price = sprintf(_("od %s"),$lowest);
			$price = sprintf(_("od %s do %s dle země doručení"),$lowest,$highest);
		}else{
			$price = smarty_modifier_display_price($price,["format" => "plain", "currency" => $currency]);
		}
		return $price;
	}

	function getImage() {
		return $this->dm->getLogo();
	}
}
