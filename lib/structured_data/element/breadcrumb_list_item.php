<?php

namespace StructuredData\Element;

class BreadcrumbListItem extends \StructuredData\BaseElement {

	function __construct(\ApplicationModel $item) {
		$this->item = $item;
	}

	function toArray() {
		$_id = null;

		switch(get_class($this->item)) {
		case "Category":
				$_id = \Atk14Url::BuildLink(["action" => "categories/detail", "path" => $this->item->getPath()], ["with_hostname" => true]);
			break;
		case "Card":
				$_id = \Atk14Url::BuildLink(["action" => "cards/detail", "id" => $this->item], ["with_hostname" => true]);
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
