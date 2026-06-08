<?php

namespace StructuredData\Element;

class VideoObject extends \StructuredData\BaseElement {

	function __construct(\Video $item, $options=[]) {
		$this->item = $item;
	}

	function toArray() {
		$out = [
			"@context" => "https://schema.org",
			"@type" => "VideoObject",
			"name" => $this->item->getTitle(),
			"embedUrl" => $this->item->g("url"),
		];

		if ($_description = $this->item->getDescription()) {
			$out["description"] = strip_tags((string)$_description);
		}

		if ($_thumbnail = $this->item->getPreviewImageUrl()) {
			$out["thumbnailUrl"] = (string)$_thumbnail;
		}

		if ($_created_at = $this->item->g("created_at")) {
			$out["uploadDate"] = (new \DateTime($_created_at))->format(\DateTime::ATOM);
		}

		return $out;
	}
}
