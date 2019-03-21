<?php
class DeliveryMethodCountrySpecificationsForm extends AdminForm {

	// Hodnota code v tomto pripade neni unique
	var $clean_code_automatically = false;

	function set_up(){

		$currency = Currency::GetDefaultCurrency();

		$this->add_field("price", new FloatField(array(
			"label" => sprintf(_("Specifická cena [%s]"),$currency),
			"min_value" => 0,
			"required" => false,
		)));

		$this->add_field("price_incl_vat", new FloatField(array(
			"label" => sprintf(_("Specifická cena s DPH [%s]"),$currency),
			"min_value" => 0,
			"required" => false,
		)));

		$this->add_code_field([
			"label" => _("Kód dopravy"),
			"help_text" => _("Kód pro export objednávky do XML")
		]);
	}

	function clean(){
		list($err,$d) = parent::clean();

		$keys = array_keys($d);

		if(in_array("price",$keys) && in_array("price_incl_vat",$keys)){
			if(
				(is_null($d["price"]) && !is_null($d["price_incl_vat"])) ||
				(!is_null($d["price"]) && is_null($d["price_incl_vat"]))
			){
				$this->set_error(_("Zadejte obě ceny nebo nechejte obě ceny prázdné"));
			}
		}

		return [$err,$d];
	}
}
