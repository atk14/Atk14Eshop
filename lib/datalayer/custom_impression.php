<?php
/**
 * Trida pro vygenerovani Impression objektu pro Enhanced Ecommerce aktivity
 */
class CustomImpression extends \DatalayerGenerator\Datatypes\EcImpression {

	function getImpressionId() {
		return $this->getObject()->getCatalogId();
	}

	function getImpressionName() {
		return $this->getObject()->getName();
	}

	function getImpressionBrand() {
		return (string)$this->getObject()->getCard()->getBrand();
	}

	function getImpressionCategory() {
		$categories = $this->getObject()->getCard()->getCategories();
		$categories = array_filter($categories, function($c) {
			$pc = $c->getParentCategory();
			if (is_null($pc)) {
				return false;
			}
			return !$pc->isFilter();
		});
		$first = array_shift($categories);
		if (is_null($first)) {
			return null;
		}
		return $first->getNamePath(null, ["start_level" => 1]);
	}

	function getImpressionVariant() {
		return null;
	}

	function getImpressionList() {
		return "category";
	}

	function getImpressionPosition() {
		return $this->options["position"];
	}

	function getImpressionPrice() {
		$price_finder = $this->options["price_finder"];
		$_price = $price_finder->getPrice($this->getObject());
		if ($_price) {
			return number_format($_price->getUnitPriceInclVat(), 0, ".", "");
		}
		return null;
	}

}
