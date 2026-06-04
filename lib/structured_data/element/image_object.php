<?php

namespace StructuredData\Element;

class ImageObject extends \StructuredData\BaseElement {

	function __construct(\ApplicationModel $item, $options=[]) {
		$this->item = $item;
	}

	function toArray() {
		$out = [
			"@context" => "https://schema.org",
			"@type" => "ImageObject",
			"contentUrl" => (string)$this->item->getUrl(),
		];

		if ($_name = $this->item->getName()) {
			$out["name"] = (string)$_name;
		}

		if ($_description = $this->item->getDescription()) {
			$out["description"] = strip_tags((string)$_description);
		}

		if (method_exists($this->item, "getAlt") && ($_caption = $this->item->getAlt())) {
			$out["caption"] = (string)$_caption;
		}

		if ($_created_at = $this->item->g("created_at")) {
			$out["uploadDate"] = (new \DateTime($_created_at))->format(\DateTime::ATOM);
		}

		return $out;
	}
}
