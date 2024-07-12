<?php

namespace StructuredData\Element;

class Offer extends \StructuredData\BaseElement {

	function __construct(\Card $item, $options=[]) {
		$options += [
			"price_finder" => null,
			"basket" => null,
			# array for mapping product tags to shipping labels
			# tag.code => label for offerShippingDetails.shippingLabel
			"tags" => [
				"oversized_product" => "oversized product",
			],
		];
		$this->options = $options;
		$this->item = $item;
	}

	function toArray() {
		$_price_finder = $this->options["price_finder"];
		$_basket = $this->options["basket"];
		$_region = $_basket->getRegion();

		$_price = null;
		$products = $this->item->getProducts();
		$_product = array_shift($products);

		if ($_price_finder) {
			$_price = $_price_finder->getStartingPrice($this->item);
		}
		$_currency = $_basket->getCurrency();
		list($_shipping_methods, $_payment_methods) = \ShippingCombination::GetAvailableMethods4Product($_product, $_basket);

		$out_shipping_details = [];
		foreach($_shipping_methods as $_sm) {
			$shipping_detail = [
				"@type" => "OfferShippingDetails",

				/**
				 * Not required for standard deliveries. it is used by Merchant Center.
				 * for some specific cases it should express type of delivery, not the name of the delivery service
				 * like oversized, 'free shipping'
				 * https://support.google.com/merchants/answer/6324504?hl=en&ref_topic=6324338&sjid=10862487511373806307-EU
				 */
					"shippingRate" => [
						"@type" => "MonetaryAmount",
						"currency" => $_currency->getCode(),
						"value" => $_sm->getPriceInclVat(),
					],
					"shippingDestination" => [
						"@type" => "DefinedRegion",
						"addressCountry" => $_region->getDeliveryCountries(),
					],
			];
			foreach($this->options["tags"] as $tag_code => $_label) {
				if ($this->item->containsTag($tag_code)) {
					$shipping_detail["shippingLabel"] = $_label;
				}
			}
			$out_shipping_details[] = $shipping_detail;
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
			"itemCondition" => "http://schema.org/NewCondition",
			"url" => \Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]),
			"availability" => $_availability,
			"seller" => [
				"@type" => "Organization",
				"name" => ATK14_APPLICATION_NAME,
			],
			"shippingDetails" => $out_shipping_details,
		];
		if ($_price) {
			$out["price"] = round($_price->getUnitPriceInclVat(), $_currency->getDecimalsSummary());
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
