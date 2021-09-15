<?php
class DeliveryMethodsForm extends AdminForm {

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

		$this->add_translatable_field("label", new CharField(array(
			"label" => _("Název dopravy"),
		)));

		$this->add_translatable_field("title", new CharField(array(
			"label" => _("Nadpis nápovědy"),
			"required" => false,
		)));

		$this->add_translatable_field("description", new MarkdownField(array(
			"label" => _("Text nápovědy"),
			"required" => false,
		)));

		$this->add_translatable_field("email_description", new CharField(array(
			"label" => _("Text nápovědy do notifikačních e-mailů"),
			"required" => false,
			"help_text" => _("Nebude-li vyplněno, použije se v případě osobního vyzvednutí adresa provozovny a její otevírací doba."),
		)));

		$this->add_field("required_customer_group_id", new CustomerGroupField(array(
			"label" => _("Only for customer group"),
			"required" => false,
		)));

		$help_text = _("Pokud nebude částka určena, znamená to, že cena za dopravu bude stanovena následnou dohodou.");
		//
		$this->add_field("price_incl_vat", new PriceField(array(
			"label" => sprintf(_("Výchozí cena s DPH [%s]"),$currency),
			"required" => false,
			"initial" => 0,
			"help_text" => $help_text,
		)));

		$this->add_vat_rate_id_field();

		$this->add_field("personal_pickup", new BooleanField(array(
			"label" => _("Osobní odběr"),
			"initial" => false,
			"required" => false,
		)));

		$this->add_field("personal_pickup_on_store_id", new StoreField(array(
			"label" => _("Vyberte prodejnu pro osobní odběr"),
			"required" => false,
			"help_text" => _("Lze vybrat pouze, pokud bude zatržen <em>osobní odběr</em>"),
		)));

		$this->add_field("designated_for_tags", new TagsField(array(
			"label" => _("Určeno pro štítky"),
			"required" => false,
			"help_text" => _("Doručovací metoda bude použita, pokud alespoń jeden produkt v košíku bude obsahovat jeden z uvedených štítků.")
		)));

		$this->add_field("excluded_for_tags", new TagsField(array(
			"label" => _("Vyloučeno pro štítky"),
			"required" => false,
			"help_text" => _("Doručovací metoda NEBUDE použita, pokud alespoń jeden produkt v košíku bude obsahovat jeden z uvedených štítků.")
		)));

		$this->add_field("required_tag_id", new TagField(array(
			"label" => _("Exkluzivně pro štítek"),
			"required" => false,
			"help_text"  => _("Doručovací metoda bude použita, pokud všechny produkty v košíku budou obsahovat tento štítek. Ostatní metody nebudou použity."),
		)));

		$this->add_code_field(array(
			"label" => _("Kód dopravy"),
			"help_text" => _("Pro systémové účely. Unikátní kód."),
		));

		$this->add_field("delivery_service_id", new DeliveryServiceField(array(
			"required" => false,
		)));

		$this->add_field("logo", new PupiqImageField(array(
			"label" => _("Logo"),
			"initial" => false,
			"required" => false
		)));

		$this->add_field("tracking_url", new UrlField(array(
			"label" => _("URL pro sledování zásilky"),
			"required" => false,
			"help_text" => _("Znak '@' v URL bude nahrazen číslem zásilky.<br>Např. 'https://www.postaonline.cz/trackandtrace/-/zasilka/cislo?parcelNumbers=@'"),
		)));
	}

	function clean(){
		list($err,$d) = parent::clean();

		$keys = is_array($d) ? array_keys($d) : array(); 

		if(in_array("personal_pickup",$keys) && in_array("personal_pickup_on_store_id",$keys)){
			if($d["personal_pickup_on_store_id"] && !$d["personal_pickup"]){
				$this->set_error("personal_pickup",_("Pokud je vybrána prodejna pro osbní odběr, zatrhněte i osobní odběr"));
			}
		}

		if(in_array("price",$keys) && in_array("price_incl_vat",$keys)){
			if(isset($d["price"]) && !isset($d["price_incl_vat"])){
				$this->set_error("price_incl_vat",_("Specify the price incl. VAT"));
			}
			if(!isset($d["price"]) && isset($d["price_incl_vat"])){
				$this->set_error("price_incl_vat",_("Specify the price"));
			}
		}

		return array($err,$d);
	}
}
