<?php
class WarehouseItemsForm extends AdminForm {

	function set_up(){
		$this->add_field("product_id", new ProductField([
			"label" => _("Product"),
		]));

		$this->add_field("stockcount", new IntegerField([
			"label" => _("Stockcount"),
		]));
	}

	function _get_conflicting_record($d){
		return WarehouseItem::FindFirst(["conditions" => [
			"warehouse_id" => $this->controller->warehouse,
			"product_id" => $d["product_id"],
		]]);
	}
}
