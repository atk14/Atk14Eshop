<?php

namespace StructuredData\Element;

class Article extends \StructuredData\BaseElement {

	function __construct(\Article $item, $options=[]) {
		$this->item = $item;
		$this->options = $options;
	}

	function toArray() {
		$article = $this->item;

		$out = [
			"@context" => "https://schema.org",
			"@type" => "Article",
			"headline" => $article->getTitle(),
			"datePublished" => (new \DateTime($article->getPublishedAt()))->format(\DateTime::ATOM),
			"url" => \Atk14Url::BuildLink(["action" => "articles/detail", "id" => $article], ["with_hostname" => true]),
			"publisher" => [
				"@id" => Organization::GetId(),
			],
		];

		if ($_description = $article->getPageDescription()) {
			$out["description"] = $_description;
		}

		// articleBody is intentionally omitted — search engines crawl the page content themselves,
		// and including the full article body in structured data would bloat the HTML unnecessarily.

		if ($_updated_at = $article->getUpdatedAt()) {
			$out["dateModified"] = (new \DateTime($_updated_at))->format(\DateTime::ATOM);
		}

		if ($_image_url = $article->getImageUrl()) {
			$out["image"] = $_image_url;
		}

		if ($_author = $article->getAuthor()) {
			$_name = trim("{$_author->getFirstname()} {$_author->getLastname()}");
			if ($_name) {
				$out["author"] = [
					"@type" => "Person",
					"name" => $_name,
				];
			}
		}

		return $out;
	}
}
