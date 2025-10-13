<?php

namespace StructuredData\Element;

class Website extends \StructuredData\BaseElement {


  /**
   */
	function toArray() {
		$_siteUrl = \Atk14Url::BuildLink(["action" => "main/index"], ["with_hostname" => true]);
		$_searchUrl = \Atk14Url::BuildLink(["action" => "searches/index"], ["with_hostname" => true])."?q={search_term_string}";
		$out = [
			'@context' => 'http://schema.org/',
			"@type" => "WebSite",
			"name" => ATK14_APPLICATION_NAME,
			"url" => $_siteUrl,
			"potentialAction" => [
				"@type" => "SearchAction",
				"target" => [
					"@type" => "EntryPoint",
					"urlTemplate" => $_searchUrl,
				],
				"query-input" => "required name=search_term_string",
			],
		];
		return $out;
	}
}

