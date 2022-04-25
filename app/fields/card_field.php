<?php
class CardField extends ObjectField{

	function __construct($options = array()){
		$options += [
			"widget" => new TextInput(["attrs" => ["placeholder" => _("... start typing name of an existing product")]]),
		];
		parent::__construct($options);

		$this->update_messages(array(
			"not_found" => _("There is no such product card"),
		));
	}

	function clean($value){

		// Lze zadat i ciste catalog_id
		$value = trim($value);
		if($value && ($p = Product::GetInstanceByCatalogId($value))){
			$value .= " [#".$p->getCardId()."]";
		}

		return parent::clean($value);
	}
}
