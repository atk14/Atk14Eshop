<?php
/**
 * Trida pro vygenerovani Product objektu pro Enhanced Ecommerce aktivity
 */
class CustomProduct extends \DatalayerGenerator\Datatypes\EcProduct {

	function getProductId() {
		return $this->getObject()->getCatalogId();
	}

	function getProductName() {
		return $this->getObject()->getName();
	}

	function getProductBrand() {
		return (string)$this->getObject()->getCard()->getBrand();
	}

	function getProductCategory() {
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

	function getProductVariant() {
		return null;
	}

	function getProductPrice() {
		$product = $this->getObject();
		$amount = $product->getUnit()->getDisplayUnitMultiplier();

		$price_finder = $this->options["price_finder"];
		if (!$price_finder) {
			return null;
		}
		$_price = $price_finder->getPrice($product, $amount);
		if ($_price) {
			return (float)number_format($_price->getUnitPriceInclVat(), 2, ".", "");
		}
		return null;
	}
}
