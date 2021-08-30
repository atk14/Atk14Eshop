<?php
class CampaignsForm extends AdminForm {

	function set_up(){
		$this->add_field("active", new BooleanField(array(
			"label" => _("Je toto aktivní kampaň"),
			"initial" => true,
			"required" => false,
		)));

		$this->add_field("regions", new RegionsField([
			"label" => _("Oblasti"),
			"json_encode" => true,
			"initial" => "__all__",
		]));

		$this->add_translatable_field("name", new CharField([
			"label" => _("Název kampaně"),
		]));

		$this->add_field("minimal_items_price_incl_vat", new PriceField([
			"label" => sprintf(_("Minimální cena zboží v košíku [%s]"),Currency::GetDefaultCurrency()),
		]));

		$this->add_field("required_customer_group_id", new CustomerGroupField(array(
			"label" => _("Only for customer group"),
			"required" => false,
		)));

		$this->add_field("required_delivery_method_id", new DeliveryMethodField(array(
			"label" => _("Uplatňuje se pouze při použitém způsobu doručení"),
			"required" => false,
		)));

		$this->add_field("required_payment_method_id", new PaymentMethodField(array(
			"label" => _("Uplatňuje se pouze při použité platební metodě"),
			"required" => false,
		)));

		$this->add_field("discount_percent", new PercentField([
			"label" => _("Procentní sleva"),
			"initial" => 0.0,
			"help_text" => _("Nastavte nulu, pokud je toto kampaň na dopravu zdarma"),
		]));

		$this->add_field("free_shipping", new BooleanField([
			"label" => _("Doprava zdarma?"),
			"required" => false,
		]));

		$this->add_field("delivery_method_id", new DeliveryMethodField([
			"label" => _("Doprava zdarma se vztahuje pouze na způsob doručení"),
			"required" => false,
			"empty_choice_text" => "-- "._("všechny způsoby")." --",
		]));


		$this->add_validity_fields();
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["discount_percent"]) && isset($d["free_shipping"])){
			if($d["discount_percent"] && $d["free_shipping"]){
				$this->set_error(_("V jedné kampani lze nastavit buďto procentní slevu nebo dopravu zdarma"));
			}
			if(!$d["discount_percent"] && !$d["free_shipping"]){
				$this->set_error(_("Je nutné nastavit buďto procentní slevu nebo dopravu zdarma"));
			}
		}

		return [$err,$d];
	}
}
