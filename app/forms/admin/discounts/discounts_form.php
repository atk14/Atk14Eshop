<?php
class DiscountsForm extends AdminForm {

	function set_up(){
		$this->add_field("discount_percent", new PercentField([
			"label" => _("Procentní sleva"),
		]));

		$this->add_field("product_id", new ProductField([
			"label" => _("Produkt"),
			"required" => false,
		]));

		$this->add_field("category_id", new CategoryField([
			"label" => _("Kategorie"),
			"required" => false,
		]));

		$this->add_validity_fields();
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["category_id"]) && isset($d["product_id"])){
			unset($d["category_id"]);
			unset($d["product_id"]);

			$this->set_error(_("Nelze zadat produkt i kategorii"));
		}

		return [$err,$d];
	}
}
