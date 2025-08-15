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
		# Search console has a limit 5000 characters for the length of description field. The length is calculated in JSON format.
		# So we convert it to json, truncate and convert back to string.
		$_description = new \String4(json_encode(strip_tags((string)$this->item->getTeaser())));
		$_description = $_description->truncate(5000, ["separator" => " "]);
		$_description = trim($_description->toString(), "\"");
		$_description = sprintf('{"t":"%s"}',$_description);
		$_description = json_decode($_description, true);
		$out = [
			"@context" => "https://schema.org",
			"@type" => "Product",
			"name" => $this->item->getName(),
			"description" => isset($_description) ? $_description["t"] : "",
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
		if ($offersAry = $offers->toArray()) {
			$out["offers"] = $offersAry;
		}
		return $out;
	}
}
