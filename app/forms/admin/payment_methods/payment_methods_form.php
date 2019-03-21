<?php
class PaymentMethodsForm extends AdminForm {

	function set_up() {
		$currency = Currency::GetDefaultCurrency();

		$this->add_field("active", new BooleanField(array(
			"label" => _("Aktivní"),
			"initial" => true,
			"required" => false,
		)));

		$this->add_field("regions", new RegionsField(array(
			"label" => _("Oblasti"),
			"json_encode" => true,
		)));

		$this->add_field("payment_gateway_id", new PaymentGatewayField(array(
			"label" => _("Platební brána"),
			"required" => false,
			"empty_choice_text" => _("nenapojeno na žádnou bránu"),
		)));

		$this->add_translatable_field("label", new CharField(array(
			"label" => _("Text ve formuláři"),
		)));

		$this->add_translatable_field("title", new CharField(array(
			"label" => _("Nadpis nápovědy"),
			"required" => false,
		)));

		$this->add_translatable_field("description", new WysiwygField(array(
			"label" => _("Text nápovědy"),
			"required" => false,
		)));

		$this->add_field("price", new FloatField(array(
			"label" => sprintf(_("Cena [%s]"),$currency),
			"min_value" => 0,
			"initial" => 0,
		)));

		$this->add_field("price_incl_vat", new FloatField(array(
			"label" => sprintf(_("Cena s DPH [%s]"),$currency),
			"min_value" => 0,
			"initial" => 0,
		)));

		$this->add_code_field(array(
			"label" => _("Kód platby"),
			"help_text" => _("Kód pro export objednávky do XML"),
		));

		$this->add_field("logo", new PupiqImageField(array(
			"label" => _("Logo"),
			"initial" => false,
			"required" => false
		)));
	}
}
