<?php
class VouchersForm extends AdminForm {

	function set_up(){
		$currency = Currency::GetDefaultCurrency();

		$this->add_field("voucher_code", new CharField([
			"label" => _("Kód"),
			"max_length" => 255,
			"help_text" => _("Písmenný kód bude automaticky převeden na velká písmena"),
		]));

		$this->add_field("discount_amount", new PriceField([
			"label" => sprintf(_("Hodnota poukazu [%s]"),$currency->getSymbol()),
			"min_value" => 0.0,
			"initial" => 0.0,
		]));

		$this->add_field("discount_percent", new PercentField([
			"label" => _("Procentní sleva poukazu"),
			"min_value" => 0.0,
			"max_value" => 100.0,
			"initial" => 0.0,
		]));

		$this->add_field("free_shipping", new BooleanField(array(
			"label" => _("Doprava zdarma?"),
			"initial" => false,
			"required" => false,
		)));

		$this->add_translatable_field("description", new CharField(array(
			"label" => _("Volný popis"),
			"required" => false,
			"help_text" => _("V případě potřeby popište zákazníkům význam tohoto slevového kupónu"),
		)));

		$this->add_field("repeatable", new BooleanField(array(
			"label" => _("Lze uplatňovat opakovaně"),
			"initial" => false,
			"required" => false,
		)));

		$this->add_field("minimal_items_price_incl_vat", new PriceField([
			"label" => sprintf(_("Minimální hodnota zboží v košíku s DPH [%s]"),$currency->getSymbol()),
			"required" => true,
			"initial" => 0,
			"min_value" => 0,
			"help_text" => _("Kupón nebude možné použít, pokud bude v košíku zboží celkem za nižší částku"),
		]));

		$this->add_field("regions", new RegionsField(array(
			"label" => _("Oblasti platnosti kupónu"),
			"json_encode" => true,
			"initial" => "__all__",
		)));

		$this->add_field("active", new BooleanField(array(
			"label" => _("Aktivní"),
			"initial" => true,
			"required" => false,
			"help_text" => _("Neaktivní slevový kupón nebude možné použít"),
		)));

		$this->add_validity_fields();
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["voucher_code"])){
			$d["voucher_code"] = Translate::Upper($d["voucher_code"]);
		}

		if(!$this->has_errors()){
			if($d["valid_from"] && $d["valid_to"]){
				$valid_from = strtotime($d["valid_from"]);
				$valid_to = strtotime($d["valid_to"]);

				if($valid_from==$valid_to){
					$this->set_error(_("Platnost od a Platnost do musí být rozdílne datumy"));
				}

				if($valid_from>$valid_to){
					$this->set_error(_("Platnost od musí být starší datum než Platnost do"));
				}
			}
		}

		return [$err,$d];
	}
}
