<?php
class TechnicalSpecificationKeyType_Integer extends TechnicalSpecificationKeyType_Base {

	function __construct(){
		parent::__construct([
			"label" => _("Celé číslo")
		]);
	}
}
