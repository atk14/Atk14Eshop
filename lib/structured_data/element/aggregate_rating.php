<?php

namespace StructuredData\Element;

class AggregateRating extends \StructuredData\BaseElement {

	function __construct(\Card $item) {
		$this->item = $item;
	}

	function toArray() {
		$review_count = 0;
		$rating_value = \CustomerReview::GetRatingFor($this->item, $review_count);

		if (!$review_count || !$rating_value) {
			return null;
		}

		return [
			"@type" => "AggregateRating",
			"ratingValue" => round($rating_value, 1),
			"ratingCount" => $review_count,
			"bestRating" => \CustomerReview::MAX_RATING,
			"worstRating" => 1,
		];
	}
}
