<?php
class Add extends DatalayerGenerator\MessageGenerators\Add implements DatalayerGenerator\MessageGenerators\iMessage {

	function __construct($object, $options=[]) {
		$options += [
			"amount" => 1,
		];
		return parent::__construct($object, $options);
	}

	function getActivityData() {
		$objDT = \DatalayerGenerator\Datatypes\ecDatatype::CreateProduct($this->getObject(), $this->options);
		$_productsAr = [];
		if ($_out = $objDT->getData()) {
			$_out["quantity"] = $this->options["amount"];
			$_productsAr[] = $_out;
		}
		return ["products" => $_productsAr];
	}
}
