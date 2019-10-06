<?php
class CreateNewForm extends CardsForm {

	function set_up() {
		$this->_add_fields(array(
			"add_catalog_id_field" => true,
			"catalog_id_required" => true, // in eshop the catalog_id is required
			"add_information_fields" => true,
		));

		// special fields for the card creation process

		$pricelist = Pricelist::GetDefaultPricelist();
		$currency = $pricelist->getCurrency();
		$this->add_field("price", new PriceField([
			"label" => sprintf(($pricelist->containsPricesWithoutVat() ? _("Cena bez DPH [%s]") : _("Koncová cena [%s]")),$currency),
			"required" => false,
			"help_text" => sprintf(_("Cena bude uložena do ceníku <em>%s</em>"),h($pricelist->getName())),
		]));

		if($base_pricelist = Pricelist::GetInstanceByCode(DEFAULT_BASE_PRICELIST)){
			$this->add_field("base_price", new PriceField([
				"label" => sprintf(($base_pricelist->containsPricesWithoutVat() ? _("Cena před slevou bez DPH [%s]") : _("Koncová cena před slevou [%s]")),$currency),
				"required" => false,
				"help_text" => sprintf(_("Cena bude uložena do ceníku <em>%s</em>"),h($base_pricelist->getName())),
			]));
		}

		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		$this->add_field("stockcount", new StockcountField([
			"label" => _("Stockcount"),
			"required" => false,
			"help_text" => sprintf(_("Skladové množství bude nastaveno do skladu <em>%s</em>"),h($warehouse->getName())),
		]));

		$this->add_field("image_url", new PupiqImageField([
			"label" => _("Image"),
			"required" => false,
			"help_text" => sprintf(_("Recommended image size is %dx%d"),1000,1000),
		]));

		$this->add_field("category", new CategoryField([
			"label" => _("Primary category"),
			"required" => false,
		]));
	}

	function clean() {
		list($err,$d) = parent::clean();

		if (isset($d["catalog_id"]) && ($product = Product::FindByCatalogId($d["catalog_id"]))) {
			$this->set_error("catalog_id", _("Zadané katalogové číslo je již použité"));
		}
		return array($err,$d);
	}
}
