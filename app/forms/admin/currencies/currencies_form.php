<?php
class CurrenciesForm extends AdminForm {

	function set_up(){
		$this->add_field("code", new CharField([
			"label" => _("Code"),
		]));

		$this->add_field("rate", new DecimalField([
			"label" => _("Conversion rate"),
			"min_value" => 0.01,
		]));

		$this->add_field("decimals", new IntegerField([
			"label" => _("Decimal places"),
			"min_value" => 0,
			"max_value" => 4,
		]));

		$this->add_field("decimals_summary", new IntegerField([
			"label" => _("Decimal places in the summary"),
			"min_value" => 0,
			"max_value" => 4,
		]));
	}
}
