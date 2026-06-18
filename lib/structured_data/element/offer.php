<?php

namespace StructuredData\Element;

class Offer extends BaseOffer {

	function toArray() {
		$_price_finder = $this->options["price_finder"];
		$_basket = $this->options["basket"];
		if (!$_basket) { return null; }
		$_currency = $_basket->getCurrency();

		$products = $this->item->getProducts();
		if (!$products) { return null; }
		$_product = array_shift($products);

		$out_shipping_details = $this->_getShippingDetails($_product);

		$_price = null;
		if ($_price_finder) {
			$_price = $_price_finder->getStartingPrice($this->item);
		}

		$stockcount = $this->_getStockcount();
		$_availability = "https://schema.org/InStock";
		if(!$_product->isVisible() || $_product->isDeleted() || !$this->item->isVisible() || $this->item->isDeleted()){
			$_availability = "https://schema.org/Discontinued";
		} elseif(!$_product->canBeOrdered()){
			$_availability = "https://schema.org/OutOfStock";
		} elseif (!$_product->considerStockcount()) {
			if (($stockcount>0) || $_product->containsTag("digital_product") || $this->item->containsTag("digital_product")) {
				$_availability = "https://schema.org/InStock";
			} else {
				$_availability = "https://schema.org/BackOrder";
			}
		}
		$out = [
			"@type" => "Offer",
			"itemCondition" => "https://schema.org/NewCondition",
			"url" => \Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]),
			"availability" => $_availability,
			"seller" => $this->_buildSeller(),
			"shippingDetails" => $out_shipping_details,
		];
		if ($_price) {
			$out["price"] = round($_price->getUnitPriceInclVat(), $_currency->getDecimals());
			$out["priceCurrency"] = $_currency->getCode();
		}

		return $out;
	}
}
