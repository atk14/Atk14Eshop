<?php
namespace StructuredData;

class Collector {

	protected $items = [];

	function __construct() {
		$this->addItem(new Element\Website());
	}

	function addItem(BaseElement $item) {
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
