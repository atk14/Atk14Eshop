<?php
/**
 * @note This class should not be used. It's intended for shopping aggregators.
 * Until we have separate url for each catalog id, we (mis)use the AggregateOffer property.
 */

namespace StructuredData\Element;

class AggregateOffer extends \StructuredData\BaseElement {

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
		$_currency = $_basket->getCurrency();
		$_rate = \CurrencyRate::GetCurrencyRate($_currency);

		$products = $this->item->getProducts();
		$_product = array_shift($products);

		$out_shipping_details = $this->_getShippingDetails($_product);

		$_price = null;
		$_distinct_prices = null;
		if ($_price_finder) {
			$_price = $_price_finder->getStartingPrice($this->item);
			$_distinct_prices = $_price_finder->getDistinctPrices($this->item);
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
				"@type" => "Organization",
				"name" => ATK14_APPLICATION_NAME,
			],
			"shippingDetails" => $out_shipping_details,
		];
		if (count($_prices)>0) {
			$lowPrice = min($_prices);
			$highPrice = max($_prices);
			$out["lowPrice"] = round($lowPrice, $_currency->getDecimals());;
			$out["highPrice"] = round($highPrice, $_currency->getDecimals());;
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

				/**
				 * Not required for standard deliveries. it is used by Merchant Center.
				 * for some specific cases it should express type of delivery, not the name of the delivery service
				 * like oversized, 'free shipping'
				 * https://support.google.com/merchants/answer/6324504?hl=en&ref_topic=6324338&sjid=10862487511373806307-EU
				 */
				"shippingLabel" => $key,

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
			# look up products tags and if specified in options["tags"] give the shipping according label
			foreach($this->options["tags"] as $tag_code => $_label) {
				if ($this->item->containsTag($tag_code)) {
					$shipping_detail["shippingLabel"] = $_label;
				}
			}
			$out_shipping_details[] = $shipping_detail;
		}
		if (count($out_shipping_details)===1) {
			$out_shipping_details = array_shift($out_shipping_details);
		}
		return $out_shipping_details;
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
