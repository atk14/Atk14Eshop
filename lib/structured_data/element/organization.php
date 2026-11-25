<?php

namespace StructuredData\Element;

class Organization extends \StructuredData\BaseElement {

	// Stable @id used to reference this organization from other structured data objects.
	const ID_FRAGMENT = "#organization";

	static function GetId() {
		return \Atk14Url::BuildLink(["action" => "main/index"], ["with_hostname" => true]) . self::ID_FRAGMENT;
	}

	function toArray() {
		$_site_url = \Atk14Url::BuildLink(["action" => "main/index"], ["with_hostname" => true]);

		$out = [
			"@context" => "https://schema.org",
			"@type" => "Organization",
			"@id" => self::GetId(),
			"name" => ATK14_APPLICATION_NAME,
			"url" => $_site_url,
		];

		if ($_logo_url = (string)\SystemParameter::ContentOn("app.favicon")) {
			$out["logo"] = [
				"@type" => "ImageObject",
				"url" => $_logo_url,
			];
		}

		return $out;
	}
}
