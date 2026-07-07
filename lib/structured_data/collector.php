<?php
namespace StructuredData;

class Collector {

	protected static $instance = null;

	protected $items = [];

	static function Reset() {
		self::$instance = null;
	}

	static function GetInstance(\Atk14Controller $controller=null, $options=[]) {
		if (!self::$instance) {
			self::$instance = new self($controller, $options);
		}
		return self::$instance;
	}

	protected function __construct(?\Atk14Controller $controller=null, $options=[]) {
		$options += [
		];
		$_is_homepage = $controller && (($controller->controller==="main") && ($controller->action==="index"));
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
			if ($ar = $_i->toArray()) {
				$itemsAr[] = $ar;
			}
		}

		return $itemsAr;
	}
}
