<?php
class TechnicalSpecificationKeyType_Float extends TechnicalSpecificationKeyType_Base {

	function __construct(){
		parent::__construct([
			"label" => _("Desetinné číslo")
		]);
	}
}
