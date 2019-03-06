<?php
class PricelistItemsForm extends AdminForm {

	function set_up(){
		$this->add_field("product_id", new ProductField([
			"label" => _("Produkt"),
		]));

		$unit = isset($this->controller->pricelist_item) ? $this->controller->pricelist_item->getProduct()->getUnit() : null;
		$this->add_field("minimum_quantity", new IntegerField([
			"label" => _("Minimální množství") . ($unit ? " [$unit]" : ""),
			"initial" => 0,
			"min_value" => 0,
		]));

		$label = _("Cena");
		if(isset($this->controller->pricelist)){
			$currency = $this->controller->pricelist->getCurrency();
			$label .= " [$currency]";
		}
		$this->add_field("price", new PriceField([
			"label" => $label,
		]));
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
