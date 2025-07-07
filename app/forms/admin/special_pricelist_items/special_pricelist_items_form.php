<?php
class SpecialPricelistItemsForm extends AdminForm {

	function set_up(){
		$this->add_field("product_id", new ProductField([
			"label" => _("Produkt"),
		]));

		$unit = isset($this->controller->pricelist_item) ? $this->controller->pricelist_item->getProduct()->getUnit() : null;

		$label = _("Cena");
		if(isset($this->controller->pricelist)){
			$pricelist = $this->controller->pricelist;

			$label = $pricelist->containsPricesWithoutVat() ? _("Cena bez DPH [%s]") : _("Koncová cena [%s]");
			$label = sprintf($label,$pricelist->getCurrency());
		}
		$this->add_field("price", new PriceField([
			"label" => $label,
			"required" => false,
		]));

		$this->add_field("discount_percent", new LocalizedDecimalField([
			"label" => _("Procentní sleva"),
			"max_digits" => 5,
			"decimal_places" => 2,
			"min_value" => 0.1,
			"max_value" => 99.9,
			"required" => false,
		]));

		$this->add_field("minimum_quantity", new IntegerField([
			"label" => _("Cena platí od minimálního množství") . ($unit ? " [$unit]" : ""),
			"initial" => 0,
			"min_value" => 0,
			"help_text" => _("Vhodným zadáním několika cen pro jeden produkt lze docílit množstevních slev"),
		]));

		$this->add_validity_fields();
	}

	function _get_conflicting_record($d){
		return SpecialPricelistItem::FindFirst(["conditions" => [
			"special_pricelist_id" => $this->controller->special_pricelist,
			"product_id" => $d["product_id"],
			"minimum_quantity" => $d["minimum_quantity"],
		]]);
	}

	function clean(){
		list($err,$d) = parent::clean();

		if($d && array_key_exists("price",$d) && array_key_exists("discount_percent",$d) && (
			(is_null($d["price"]) && is_null($d["discount_percent"])) ||
			(!is_null($d["price"]) && !is_null($d["discount_percent"]))
		)){
			$this->set_error(_("Zadejte cenu nebo procentní slevu"));
		}

		return [$err,$d];
	}
}
