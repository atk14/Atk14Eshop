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

		$this->add_translatable_field("email_description", new WysiwygField(array(
			"label" => _("Text nápovědy do notifikačních e-mailů"),
			"required" => false,
		)));

		$this->add_field("price", new FloatField(array(
			"label" => sprintf(_("Výchozí cena [%s]"),$currency),
			"min_value" => 0,
		)));

		$this->add_field("price_incl_vat", new FloatField(array(
			"label" => sprintf(_("Výchozí cena s DPH [%s]"),$currency),
			"min_value" => 0,
		)));

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

		$this->add_field("required_tag_id", new TagField(array(
			"label" => _("Povinné klíčové slovo"),
			"required" => false,
			"help_text"  => _("Doručovací metodu bude možné použít jen v případě, že všechny produkty v košíku budou obsahovat požadované klíčové slovo."),
		)));

		$this->add_code_field(array(
			"label" => _("Kód dopravy"),
			"help_text" => _("Pro systémové účely. Unikátní kód."),
		));

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
				$this->set_error("personal_pickup",_("Pokud je vybrába prodejna pro osbní odběr, zatrhněte i osobní odběr"));
			}
		}

		return array($err,$d);
	}
}
