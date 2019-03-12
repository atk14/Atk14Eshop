<?php
/**
 * Pole pro vyber platebni metody behem dokoncovani objednavky
 */
class PaymentMethodAtCheckoutField extends ChoiceFieldWithImages {

	function __construct($options = []){
		$options += [
			"online_payment_methods_required" => false,
		];

		$this->online_payment_methods_required = $options["online_payment_methods_required"];
		unset($options["online_payment_methods_required"]);

		parent::__construct($options);
	}

	function getChoices($options){
		$conditions = $bind_ar = [];

		$conditions[] = "active";

		$conditions[] = "(regions->>:region)::BOOLEAN";
		$bind_ar[":region"] = $options["region"]->getCode();

		if($this->online_payment_methods_required){
			// za online platbu se povazuje i bankovni prevod;
			// ASI-SK-PL-BU je kod u bankovniho prevodu na Slovensku
			$conditions[] = "payment_gateway_id IS NOT NULL OR code IN ('cs_banktransfer','eu_banktransfer','ASI-SK-PL-BU')";
		}

		$choices = [];
		foreach(PaymentMethod::FindAll(["conditions" => $conditions, "bind_ar" => $bind_ar]) as $o){
			$choices[$o->getId()] = new PaymentMethodChoice($o, $options);
		}
		return $choices;
	}
}

class PaymentMethodChoice {
  function __construct($pm, $options) {
    $this->options = $options;
    $this->pm = $pm;
  }

  function getLabel() {
		return $this->pm->getLabel();
    return $this->pm->getLabel()." (".join(", ",$this->pm->getRegions()).")";
  }

  function getHint() {
    return $this->pm->getDescription();
  }

  function getHintTitle() {
    return $this->pm->getTitle();
  }

	function getPrice() {
			if ($this->options["display_prices"]!==true) {
				return null;
			}
			$rate = $this->options['currency_rate'];
			$price = $this->pm->getPriceInclVat() / $rate;
			if($price==0.0 || $this->options["free_shipping"]){
				$price = 0;
			}else{
				$price = smarty_modifier_display_price($price,["format" => "plain", "currency" => $currency]);
			}
			return $price;
	}

	function getImage() {
		return $this->pm->getLogo();
	}
}
