<?php

namespace StructuredData;

class Website extends BaseElement {


  /**
   */
	function toArray() {
		$_siteUrl = \Atk14Url::BuildLink(["action" => "main/index"], ["with_hostname" => true]);
		$_searchUrl = \Atk14Url::BuildLink(["action" => "search/search"], ["with_hostname" => true])."?q={search_term_string}";
		$out = [
			'@context' => 'http://schema.org/',
			"@type" => "WebSite",
			"url" => $_siteUrl,
			"potentialAction" => [
				"@type" => "SearchAction",
				"target" => [
					"@type" => "EntryPoint",
					"urlTemplate" => $_searchUrl,
				],
				"query-input" => [
					"@type" => "PropertyValueSpecification",
					"valueRequired" => "http://schema.org/True",
					"valueName" => "search_term_string",
				],
			],
		];
		return $out;
	}
}

