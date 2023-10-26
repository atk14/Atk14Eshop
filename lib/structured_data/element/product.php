<?php

namespace StructuredData\Element;
use StructuredData\Element\Offer;

class Product extends \StructuredData\BaseElement {
	function __construct(\Card $item, $options=[]) {
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
		if ($_images = $this->item->getImages()) {
			$_images = array_map(function ($i) { return (string)$i; }, $_images);
			$out["image"] = $_images;
		}
		if ($_brand = $this->item->getBrand()) {
			$out["brand"] = [
				"@type" => "Brand",
				"name" => "{$_brand}",
			];
		}

		if (count($this->item->getProducts())>1) {
			$offers = new AggregateOffer($this->item, $this->options);
		} else {
			$offers = new Offer($this->item, $this->options);
		}
		if ($offers->toArray()) {
			$out["offers"] = $offers->toArray();
		}
		return $out;
	}
}
