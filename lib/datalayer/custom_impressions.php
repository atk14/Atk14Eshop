<?php
class CustomImpressions extends DatalayerGenerator\MessageGenerators\Impressions implements DatalayerGenerator\MessageGenerators\iMessage {

	function getActivityData() {
		$price_finder = $this->options["price_finder"];
		$out = [];
		$_position = 1;
		foreach($this->getObject() as $_o) {
			foreach($_o->getProducts() as $_p) {
				$options = [
					"position" => $_position,
					"price_finder" => $this->options["price_finder"],
				];
				$objDT = \DatalayerGenerator\Datatypes\EcDatatype::CreateImpression($_p, $options);
				if ($_out = $objDT->getData()) {
					$out[] = $_out;
					$_position++;
				}
			}
		}
		return $out;
	}
}
