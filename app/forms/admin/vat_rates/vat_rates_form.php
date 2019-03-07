<?php
class VatRatesForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
		)));

		$this->add_field("vat_percent", new FloatField(array(
			"label" => _("VAT percent"),
			"min_value" => 0,
			"max_value" => 100.0,
		)));

		$this->add_code_field();
	}
}
