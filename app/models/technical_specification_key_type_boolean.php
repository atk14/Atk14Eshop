<?php
class TechnicalSpecificationKeyType_Boolean extends TechnicalSpecificationKeyType_Base {

	function __construct(){
		parent::__construct([
			"label" => _("Přepínač"),
			"field_class" => "BooleanWithSelectField",
		]);
	}
}
