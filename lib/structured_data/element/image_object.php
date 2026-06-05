<?php

namespace StructuredData\Element;

class ImageObject extends \StructuredData\BaseElement {

	const THUMBNAIL_GEOMETRY = "300x300";

	function __construct(\ApplicationModel $item, $options=[]) {
		$options += [
			"include_thumbnail" => true,
		];
		$this->item = $item;
		$this->options = $options;
	}

	function toArray() {
		$out = [
			"@context" => "https://schema.org",
			"@type" => "ImageObject",
			"contentUrl" => (string)$this->item->getUrl(),
		];

		if ($this->options["include_thumbnail"]) {
			$thumbnail = new self($this->item, ["include_thumbnail" => false]);
			$thumbnail_out = $thumbnail->toArray();
			$thumbnail_out["contentUrl"] = (string)$this->item->getUrl(self::THUMBNAIL_GEOMETRY);
			$out["thumbnail"] = $thumbnail_out;
		}

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
