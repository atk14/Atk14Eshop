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

		$stockcount=$this->_getStockcount();
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
			"seller" => [
				"@type" => "Organization",
				"name" => ATK14_APPLICATION_NAME,
			],
			"shippingDetails" => $out_shipping_details,
		];
		if ($_price) {
			$out["price"] = round($_price->getUnitPriceInclVat(), $_currency->getDecimals());
			$out["priceCurrency"] = $_currency->getCode();
		}

		return $out;
	}

	protected function _getShippingDetails($product) {
		$_basket = $this->options["basket"];
		$_region = $_basket->getRegion();
		$_currency = $_basket->getCurrency();

		$_rate = \CurrencyRate::GetCurrencyRate($_currency);
		list($_shipping_methods, $_payment_methods) = \ShippingCombination::GetAvailableMethods4Product($product, $_basket);

		$out_shippings = [
			"standard" => null,
			"personal" => null,
		];
		foreach($_shipping_methods as $_sm) {
			if ($_sm->personalPickup()) {
				if (
					is_null($out_shippings["personal"]) || 
					$_sm->getPriceInclVat() < $out_shippings["personal"]->getPriceInclVat()
				) {
					$out_shippings["personal"] = $_sm;
				}
			} else {
				if (
					is_null($out_shippings["standard"]) || 
					$_sm->getPriceInclVat() < $out_shippings["standard"]->getPriceInclVat()
				) {
					$out_shippings["standard"] = $_sm;
				}
			}
		}


		$out_shipping_details = [];
		foreach(array_filter($out_shippings) as $key => $_sm) {
			$value = $_sm->getPriceInclVat() / $_rate;
			$value = round($value, $_currency->getDecimals());
			$shipping_detail = [
				"@type" => "OfferShippingDetails",
				"shippingRate" => [
					"@type" => "MonetaryAmount",
					"currency" => $_currency->getCode(),
					"value" => $value,
				],
				"shippingDestination" => [
					"@type" => "DefinedRegion",
					"addressCountry" => $_region->getDeliveryCountries(),
				],
			];
			$out_shipping_details[] = $shipping_detail;
		}
		if (count($out_shipping_details)===1) {
			$out_shipping_details = array_shift($out_shipping_details);
		}
		return $out_shipping_details;
	}

	protected function _getStockcount() {
		$products = $this->item->getProducts();
		if (!$products) { return 0; }
		$unit = $products[0]->getUnit();
		$max = 0;
		foreach($products as $_product){
			if($_product->getUnitId()!==$unit->getId()){ return 0; } // mixed units
			if(!$_product->canBeOrdered()){ continue; }
			$max += $_product->getCalculatedMaximumQuantityToOrder(["real_quantity" => true]);
		}

		$_multiplier = $unit->getDisplayUnitMultiplier();
		$stockcount = $_multiplier ? $max / $_multiplier : 0;
		return $stockcount;
	}
}
