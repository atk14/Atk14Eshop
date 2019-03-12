<?php
/**
 * Pole pro vyber dorucovaci metody behem dokoncovani objednavky
 */
class DeliveryMethodAtCheckoutField extends ChoiceFieldWithImages {

	function __construct($options = []){
		$options += [
			"online_payment_methods_required" => false,
			"basket" => null,
		];

		$this->online_payment_methods_required = $options["online_payment_methods_required"];
		unset($options["online_payment_methods_required"]);

		$this->basket = $options["basket"];

		parent::__construct($options);
	}

	function getChoices($options) {
		$region = $options["region"];
		if(is_numeric($region)){ $region = Region::FindById($region); }

		$conditions = $bind_ar = [];
		$conditions[] = "active";

		if($region){
			$conditions[] = "(regions->>:region)::BOOLEAN";
			$bind_ar[":region"] = $region->getCode();
		}

		if($this->online_payment_methods_required){
			$conditions[] = "id IN (SELECT delivery_method_id FROM shipping_combinations WHERE payment_method_id IN (SELECT id FROM payment_methods WHERE payment_gateway_id IS NOT NULL".($region ? " AND (regions->>:region)::BOOLEAN))" : "");
		}

		$choices = [];
		foreach(DeliveryMethod::FindAll([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
		]) as $o){
			if($tag_required = $o->getRequiredTag()){
				if(!$this->basket->hasEveryProductTag($tag_required)){
					continue;
				}
			}
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

		$price = $o->getPriceInclVat() / $rate;
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
