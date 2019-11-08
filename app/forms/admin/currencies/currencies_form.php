<?php
class CurrenciesForm extends AdminForm {

	function set_up(){
		$this->add_field("code", new CharField([
			"label" => _("Code"),
		]));

		$this->add_field("rate", new DecimalField([
			"label" => _("Conversion rate"),
			"min_value" => 0.01,
			"help_text" => sprintf(_("Specify <em>X</em> for the equation <em>1 %s = X %s</em>"),$this->controller->currency,Currency::GetDefaultCurrency()),
		]));

		$this->add_field("decimals", new IntegerField([
			"label" => _("Decimal places"),
			"min_value" => 0,
			"max_value" => 4,
			"help_text" => _("Decimal places used, for instance, in a product detail"),
		]));

		$this->add_field("decimals_summary", new IntegerField([
			"label" => _("Decimal places in the summary"),
			"min_value" => 0,
			"max_value" => 4,
			"help_text" => _("Decimal places used in the total price of an order"),
		]));
	}
}
