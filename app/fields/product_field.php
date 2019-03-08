<?php
class ProductField extends ObjectField {

	function __construct($options = array()){
		parent::__construct($options);

		$this->update_messages(array(
			"not_found" => _("There is no such product"),
		));
	}

	function clean($value){

		// Lze zadat i ciste catalog_id
		$value = trim($value);
		if($value && ($p = Product::GetInstanceByCatalogId($value))){
			$value .= " [#".$p->getId()."]";
		}

		return parent::clean($value);
	}
}
