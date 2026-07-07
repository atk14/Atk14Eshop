<?php
/**
 * @note This class should not be used. It's intended for shopping aggregators.
 * Until we have separate url for each catalog id, we (mis)use the AggregateOffer property.
 */

namespace StructuredData\Element;

class AggregateOffer extends BaseOffer {

	function toArray() {
		$_price_finder = $this->options["price_finder"];
		$_basket = $this->options["basket"];
		if (!$_basket) { return null; }
		$_currency = $_basket->getCurrency();
		$_rate = \CurrencyRate::GetCurrencyRate($_currency);

		$products = $this->item->getProducts();
		if (!$products) { return null; }
		$_product = array_shift($products);

		$out_shipping_details = $this->_getShippingDetails($_product);

		$_price = null;
		$_distinct_prices = [];
		if ($_price_finder) {
			$_price = $_price_finder->getStartingPrice($this->item);
			$_distinct_prices = $_price_finder->getDistinctPrices($this->item);
		}

		$stockcount = $this->_getStockcount();
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
			"itemCondition" => "https://schema.org/NewCondition",
			"url" => \Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]),
			"availability" => $_availability,
			"offerCount" => count($this->item->getProducts()),
			"seller" => $this->_buildSeller(),
			"shippingDetails" => $out_shipping_details,
		];
		if (count($_prices)>0) {
			$lowPrice = min($_prices);
			$highPrice = max($_prices);
			$out["lowPrice"] = round($lowPrice, $_currency->getDecimals());
			$out["highPrice"] = round($highPrice, $_currency->getDecimals());
			$out["priceCurrency"] = $_currency->getCode();
		}

		return $out;
	}
}
