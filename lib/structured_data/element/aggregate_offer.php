<?php

namespace StructuredData\Element;

class AggregateOffer extends \StructuredData\BaseElement {

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
		$_distinct_prices = null;
		if ($_price_finder) {
			$_price = $_price_finder->getStartingPrice($this->item);
			$_distinct_prices = $_price_finder->getDistinctPrices($this->item);
		}
		$_currency = $_basket->getCurrency();
		list($_shipping_methods, $_payment_methods) = \ShippingCombination::GetAvailableMethods4Basket($_basket);

		$out_shipping_details = [];
		foreach($_shipping_methods as $_sm) {
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
		$_availability = "https://schema.org/InStock";
		if(!$this->item->isVisible() || $this->item->isDeleted()){
			$_availability = "https://schema.org/Discontinued";
		} elseif(!$this->item->canBeOrdered()){
			$_availability = "https://schema.org/OutOfStock";
		} elseif ($stockcount>0) {
			$_availability = "https://schema.org/InStock";
		} else {
			$_availability = "https://schema.org/BackOrder";
		}
		$_prices = [];
		foreach($_distinct_prices as $_dp) {
			$_prices[] = $_dp->getPriceInclVat();
		}

		$out = [
			"@type" => "AggregateOffer",
			"itemCondition" => "http://schema.org/NewCondition",
			"url" => \Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]),
			"availability" => $_availability,
			"offerCount" => count($this->item->getProducts()),
			"seller" => [
				"@type" => "Thing",
				"name" => ATK14_APPLICATION_NAME,
			],
			"shippingDetails" => $out_shipping_details,
		];
		if (count($_prices)>1) {
			$out["lowPrice"] = min($_prices);
			$out["highPrice"] = max($_prices);
			$out["priceCurrency"] = $_currency->getCode();
		}

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
