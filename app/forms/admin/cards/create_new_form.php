<?php
class CreateNewForm extends CardsForm {

	function set_up() {
		$this->_add_fields(array(
			"add_catalog_id_field" => true,
			"catalog_id_required" => true, // in eshop the catalog_id is required
			"add_information_fields" => true,
		));

		// special fields for the card creation process

		$this->add_price_field_for_default_pricelist();

		$this->add_price_field_for_base_pricelist();

		$this->add_stockcount_field_for_default_warehouse();

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

		$this->_clean_catalog_id($d);

		return array($err,$d);
	}
}
