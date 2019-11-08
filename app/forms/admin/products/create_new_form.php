<?php
class CreateNewForm extends ProductsForm {

	function set_up(){
		parent::set_up();

		// special fields for the card creation process

		$pricelist = Pricelist::GetDefaultPricelist();
		$currency = $pricelist->getCurrency();
		$this->add_field("price", new PriceField([
			"label" => sprintf(($pricelist->containsPricesWithoutVat() ? _("Cena bez DPH [%s]") : _("Koncová cena [%s]")),$currency),
			"required" => false,
			"help_text" => sprintf(_("Cena bude uložena do ceníku <em>%s</em>"),h($pricelist->getName())),
		]));

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
	}

	function clean() {
		list($err,$d) = parent::clean();

		$this->_clean_catalog_id($d);

		return array($err,$d);
	}
}
