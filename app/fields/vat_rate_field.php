<?php
class VatRateField extends ObjectChoiceField {

	function __construct($options = []){
		$options += [
			"order_by" => "rank, id",
			"value_formatter" => function($vat_rate){ return sprintf('%s (%s%s)',$vat_rate->getName(),$vat_rate->getVatPercent(),"%"); },
		];

		parent::__construct($options);
	}
}
