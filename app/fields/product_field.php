<?php
class ProductField extends ObjectField {

	function clean($value){

		// Lze zadat i ciste catalog_id
		$value = trim($value);
		if($value && ($p = Product::GetInstanceByCatalogId($value))){
			$value .= " [#".$p->getId()."]";
		}

		return parent::clean($value);
	}
}
