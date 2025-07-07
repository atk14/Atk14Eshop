<?php
class PricelistItemsForm extends AdminForm {

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
		return PricelistItem::FindFirst(["conditions" => [
			"pricelist_id" => $this->controller->pricelist,
			"product_id" => $d["product_id"],
			"minimum_quantity" => $d["minimum_quantity"],
			"price" => $d["price"],
		]]);
	}
}
