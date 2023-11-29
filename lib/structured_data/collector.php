<?php
namespace StructuredData;

class Collector {

	protected $items = [];

	function __construct(\Atk14Controller $controller, $options=[]) {
		$options += [
		];
		$_is_homepage = (($controller->controller==="main") && ($controller->action==="index"));
		if ($_is_homepage) {
			$this->addItem(new Element\Website());
		}
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
