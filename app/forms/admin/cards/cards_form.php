<?php
class CardsForm extends AdminForm{

	function _add_fields($options = array()) {
		$options += array(
			"add_catalog_id_field" => true,
			"add_vat_rate_id_field" => true,
			"catalog_id_required" => true,
			"add_information_fields" => false,
		);

		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
		)));

		if($options["add_catalog_id_field"]){
			$this->add_field("catalog_id", new CatalogIdField(array(
				"label" => _("Catalog number"),
				"required" => $options["catalog_id_required"],
			)));
		}

		if($options["add_vat_rate_id_field"]){
			$this->add_vat_rate_id_field();
		}

		$this->add_translatable_field("teaser", new MarkdownField(array(
			"label" => _("Teaser"),
			"required" => false,
			"help_text" => _("Brief description"),
		)));

		if($options["add_information_fields"]){
			$this->add_translatable_field("information", new MarkdownField(array(
				"label" => _("Information"),
				"required" => false,
				"help_text" => _("Detailed description"),
			)));
		}

		$this->add_field("brand_id", new BrandField(array(
			"label" => _("Brand"),
			"required" => false,
		)));
		$this->add_field("collection_id", new CollectionField(array(
			"label" => _("Collection"),
		)));
		$this->add_field("tags", new TagsField(array(
			"label" => _("Tags"),
			"required" => false,
			"create_missing_tags" => true,
			"hint" => "akce , novinka"
		)));
		
		$this->add_visible_field(array(
			"label" => _("Is product visible?"),
		));
	}

	function add_price_field_for_default_pricelist($values = []){
		$pricelist = Pricelist::GetDefaultPricelist();
		$currency = $pricelist->getCurrency();
		$values += [
			"label" => sprintf(($pricelist->containsPricesWithoutVat() ? _("Cena bez DPH [%s]") : _("Koncová cena [%s]")),$currency),
			"required" => false,
			"help_text" => sprintf(_("Cena bude uložena do ceníku <em>%s</em>"),h($pricelist->getName())),
		];
		$this->add_field("price", new PriceField($values));
	}

	/**
	 *
	 * Adds no field when the base base price list doesn't exist.
	 */
	function add_price_field_for_base_pricelist($values = []){
		$base_pricelist = Pricelist::GetInstanceByCode(DEFAULT_BASE_PRICELIST);
		if($base_pricelist){
			$currency = $base_pricelist->getCurrency();
			$values += [
				"label" => sprintf(($base_pricelist->containsPricesWithoutVat() ? _("Cena před slevou bez DPH [%s]") : _("Koncová cena před slevou [%s]")),$currency),
				"required" => false,
				"help_text" => sprintf(_("Cena bude uložena do ceníku <em>%s</em>"),h($base_pricelist->getName())),
			];
			$this->add_field("base_price", new PriceField($values));
		}
	}

	function add_stockcount_field_for_default_warehouse($values = []){
		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		$values += [
			"label" => _("Stockcount"),
			"required" => false,
			"help_text" => sprintf(_("Skladové množství bude nastaveno do skladu <em>%s</em>"),h($warehouse->getName())),
		];
		$this->add_field("stockcount", new StockcountField($values));
	}
}