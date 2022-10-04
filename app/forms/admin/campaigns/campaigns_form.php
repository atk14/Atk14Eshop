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

		$this->add_field("designated_for_tags", new TagsField(array(
			"label" => _("Určeno pro štítky"),
			"required" => false,
			"help_text" => _("Kampaň bude uvažována, pokud alespoň jeden produkt v košíku bude obsahovat jeden z uvedených štítků.")
		)));

		$this->add_field("excluded_for_tags", new TagsField(array(
			"label" => _("Vyloučeno pro štítky"),
			"required" => false,
			"help_text" => _("Kampaň NEBUDE uvažována, pokud alespoň jeden produkt v košíku bude obsahovat jeden z uvedených štítků.")
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

		$f = $this->add_field("gift_product_id", new ProductField([
			"label" => _("Dárek k objednávce"),
			"required" => false,
		]));
		$f->widget->attrs["placeholder"] = _("Začněte psát název produktu");

		$this->add_field("gift_amount", new IntegerField([
			"label" => _("Počet dárků"),
			"min_value" => 1,
			"required" => false,
		]));

		$this->add_field("gift_multiply", new BooleanField([
			"label" => _("Zvyšovat počet dárků podle hodnoty objednávky?"),
			"required" => false,
		]));

		$this->add_validity_fields();
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(array_key_exists("discount_percent",$d) && array_key_exists("free_shipping",$d) && array_key_exists("gift_product_id",$d)){
			$cnt = (bool)$d["discount_percent"] + (bool)$d["free_shipping"] + (bool)$d["gift_product_id"];
			if($cnt>1){
				$this->set_error(_("V jedné kampani lze nastavit buďto procentní slevu, dopravu zdarma nebo dárkový produkt"));
			}
			if($cnt === 0){
				$this->set_error(_("Je nutné nastavit buďto procentní slevu, dopravu zdarma nebo dárkový produkt"));
			}
		}

		if(array_key_exists("gift_product_id",$d) && array_key_exists("gift_amount",$d) && array_key_exists("gift_multiply",$d)){
			if($d["gift_product_id"]){
				if(is_null($d["gift_amount"])){
					$this->set_error("gift_amount",_("Stanovte počet dárků"));
				}
			}else{
				if($d["gift_amount"]>1){
					$this->set_error("gift_amount",_("Toto pole musí zůstat prázdné"));
				}
				if($d["gift_multiply"]){
					$this->set_error("gift_multiply",_("Tato možnost nemůže být aktivní"));
				}
				$d["gift_amount"] = null;
				$d["gift_multiply"] = null;
			}
		}

		return [$err,$d];
	}
}
