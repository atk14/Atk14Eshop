<?php
require_once(__DIR__ . "/../cards/cards_form.php");

class CreateNewForm extends CardsForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Name"),
		)));

		$this->add_field("catalog_id", new CatalogIdField(array(
			"label" => _("Catalog number"),
		)));

		$this->add_visible_field([
			"label" => _("Should the new product be visible?"),
			"initial" => false,
		]);

		$this->add_price_field_for_default_pricelist();
		$this->add_price_field_for_base_pricelist();
		$this->add_stockcount_field_for_default_warehouse();

		foreach([
			"copy_categories" => _("Copy categories?"),
			"copy_textual_sections" => _("Copy textual sections?"),
			"copy_technical_specifications" => _("Copy technical specifications?"),
		] as $key => $label){
			$this->add_field($key, new BooleanField([
				"label" => $label,
				"initial" => true,
				"required" => false,
			]));
		}

		$this->set_button_text(_("Create new product"));
	}

	function tune_for_card($card){
		global $ATK14_GLOBAL;

		foreach($ATK14_GLOBAL->getSupportedLangs() as $l){
			$this->set_initial("name_$l",$card->g("name_$l"));
		}
	}

	function clean() {
		list($err,$d) = parent::clean();

		$this->_clean_catalog_id($d);

		return array($err,$d);
	}
}
