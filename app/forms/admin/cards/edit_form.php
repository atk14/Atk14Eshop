<?php
class EditForm extends CardsForm {
	
	function set_up() {
		$has_variants = $this->controller->card->hasVariants();
		$this->_add_fields(array(
			"add_catalog_id_field" => !$has_variants,
			"add_vat_rate_id_field" => !$has_variants,
			"add_unit_id_field" => !$has_variants,
			"add_consider_stockcount_field" => !$has_variants,
		));
		$this->add_slug_field();
	}

	function clean() {
		list($err,$d) = parent::clean();

		$this->_clean_catalog_id($d);

		return array($err,$d);
	}
}
