<?php

namespace StructuredData\Element;

class Offer extends \StructuredData\BaseElement {

	function __construct(\Card $item, $options=[]) {
		$options += [
			"price_finder" => null,
			"basket" => null,
		];
		$this->options = $options;
		$this->item = $item;
	}

	function toArray() {
		$_price_finder = $this->options["price_finder"];
		$_basket = $this->options["basket"];

		$_price = null;
		if ($_price_finder) {
			$_price = $_price_finder->getStartingPrice($this->item);
		}
		if (is_null($_price)) {
			return null;
		}
		$_currency = $_basket->getCurrency();
		list($_shipping_methods, $_payment_methods) = \ShippingCombination::GetAvailableMethods4Basket($_basket);

		$out_shipping_details = [];
		foreach($_shipping_methods as $_sm) {
			if ($_sm->personalPickup()) {
				continue;
			}
			$out_shipping_details[] = [
					"@type" => "OfferShippingDetails",
					"shippingLabel" => $_sm->getLabel(),
					"shippingRate" => [
						"@type" => "MonetaryAmount",
						"currency" => $_currency->getCode(),
						"value" => $_sm->getPriceInclVat(),
					],
			];
		}

		$stockcount=$this->_getStockcount();
		$products = $this->item->getProducts();
		$_product = $products[0];
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
			"itemCondition" => "http://schema.org/NewCondition",
			"url" => \Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]),
			"availability" => $_availability,
			"price" => $_price->getUnitPriceInclVat(),
			"priceCurrency" => $_currency->getCode(),
			"seller" => [
				"@type" => "Thing",
				"name" => ATK14_APPLICATION_NAME,
			],
			"shippingDetails" => $out_shipping_details,
		];

		return $out;
	}

	protected function _getStockcount() {
		$products = $this->item->getProducts();
		$unit = $products[0]->getUnit();
		$max = 0;
		foreach($products as $_product){
			if($_product->getUnitId()!==$unit->getId()){ return; } // mixed units
			if(!$_product->canBeOrdered()){ continue; }
			$max += $_product->getCalculatedMaximumQuantityToOrder(["real_quantity" => true]);
		}

		$stockcount = $max / $unit->getDisplayUnitMultiplier();
		return $stockcount;
	}
}
