<?php
class EditForm extends CustomerReviewsForm {

	function set_up(){
		$this->add_field("customer_review_status_id", new CustomerReviewStatusField([
			"label" => _("Review status"),
		]));

		$this->add_field("author", new CharField([
			"label" => _("Author"),
			"max_length" => 200,
		]));

		$this->add_field("rating", new IntegerField([
			"label" => _("Rating"),
			"min_value" => 1,
			"max_value" => CustomerReview::MAX_RATING,
		]));

		$this->add_field("title", new CharField([
			"label" => _("Title"),
			"max_length" => 200,
		]));

		$this->add_field("body", new TextField([
			"label" => _("Review"),
			"max_length" => 2000,
		]));
	}
}
