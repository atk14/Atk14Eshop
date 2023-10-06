<?php

class StructuredData {

	protected $items = [];

	function __construct() {
		$this->addItem(new StructuredDataWebsite());
	}

	function addItem(StructuredDataElement $item) {
		$this->items[] = $item;
	}

	function toArray() {
		$itemsAr = [];
		foreach($this->items as $_i) {
			$itemsAr[] = $_i->toArray();
		}

		return $itemsAr;
	}
}


class StructuredDataElement {
}

class StructuredDataWebsite extends StructuredDataElement {


  /**
   */
	function toArray() {
		$_siteUrl = Atk14Url::BuildLink(["action" => "main/index"], ["with_hostname" => true]);
		$_searchUrl = Atk14Url::BuildLink(["action" => "search/search"], ["with_hostname" => true])."?q={search_term_string}";
		$out = [
			'@context' => 'http://schema.org/',
			"@type" => "WebSite",
			"url" => $_siteUrl,
			"potentialAction" => [
				"@type" => "SearchAction",
				"target" => [
					"@type" => "EntryPoint",
					"urlTemplate" => $_searchUrl,
				],
				"query-input" => [
					"@type" => "PropertyValueSpecification",
					"valueRequired" => "http://schema.org/True",
					"valueName" => "search_term_string",
				],
			],
		];
		return $out;
	}
}

class StructuredDataProduct extends StructuredDataElement {
	function __construct(Card $item, $options=[]) {
		$this->options = $options;
		$this->item = $item;
	}

	function toArray() {
		if (!$this->item->getFirstProduct()) {
			return null;
		}
		$out = [
			"@context" => "https://schema.org",
			"@type" => "Product",
			"name" => $this->item->getName(),
			"description" => $this->item->getTeaser(),
			"sku" => $this->item->getFirstProduct()->getCatalogId(), /* @todo vybrat spravny produkt */
		];
		if ($_brand = $this->item->getBrand()) {
			$out["brand"] = [
				"@type" => "Brand",
				"name" => "{$_brand}",
			];
		}
		$offers = new StructuredDataOffer($this->item, $this->options);
		$out["offers"] = $offers->toArray();
		return $out;
	}
}

class StructuredDataOffer extends StructuredDataElement {

	function __construct(Card $item, $options=[]) {
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
		$_currency = $_basket->getCurrency();
		list($_shipping_methods, $_payment_methods) = ShippingCombination::GetAvailableMethods4Basket($_basket);

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
			"url" => Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]),
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


/**
 * Example 1
 * ```
 * $bclist = new StructuredDataBreadcrumbList($card->getPrimaryCategory(), ["add_parent_elements" => true]);
 * $bclist->addListItem($card);
 * ```
 *
 * Example 2
 * ```
 * $bclist = new StructuredDataBreadcrumbList();
 * $bclist->addListItem($card->getPrimaryCategory(), ["add_parent_elements" => true]);
 * $bclist->addListItem($card);
 * ```
 *
 */
class StructuredDataBreadcrumbList extends StructuredDataElement {

	function __construct(ApplicationModel $item=null, $options=[]) {
		$options += [
			"add_index" => true,
		];
		$this->options = $options;

		if (is_null($item)) {
			return;
		}

		$this->addListItem($item, $options);
	}

	function addListItem(ApplicationModel $item, $options=[]) {
		$options += [
			"add_parent_elements" => false,
		];
		if ($options["add_parent_elements"] && ($item instanceof Category)) {
			$_items = Category::GetInstancesOnPath($item->getPath());
			foreach($_items as $_i) {
				$this->list_items[] = $item;
			}
			return;
		}
		$this->list_items[] = $item;
	}

	function toArray() {
		$_position = 1;
		$out = [
			"@context" => "https://schema.org",
			"@type" => "BreadcrumbList",
			"itemListElement" => [ ],
		];
		if ($this->options["add_index"]) {
			$out["itemListElement"][] = [
				"@type" => "ListItem",
				"position" => $_position++,
				"name" => "Úvod",
				"item" => [
					"@type" => "Thing",
					"@id" => Atk14Url::BuildLink(["action" => "main/index"], ["with_hostname" => true]),
				],
			];
		}

		foreach($this->list_items as $_path => $_c) {
			$sd_item = new StructuredDataBreadcrumbListItem($_c);
			$itemAr = $sd_item->toArray();
			$itemAr["position"] = $_position++;
			$out["itemListElement"][] = $itemAr;
		}

		return $out;
	}
}

class StructuredDataBreadcrumbListItem extends StructuredDataElement {

	function __construct(ApplicationModel $item) {
		$this->item = $item;
	}

	function toArray() {
		$_id = null;

		switch(get_class($this->item)) {
		case "Category":
				$_id = Atk14Url::BuildLink(["action" => "categories/detail", "path" => $this->item->getPath()], ["with_hostname" => true]);
			break;
		case "Card":
				$_id = Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]);
			break;
		default:
			break;
		}
		$out = [
			"@type" => "ListItem",
			"name" => $this->item->getName(),
			"item" => [
				"@type" => "Thing",
				"@id" => $_id,
			],
		];
		return $out;

	}
}
