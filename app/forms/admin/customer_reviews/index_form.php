<?php
class IndexForm extends CustomerReviewsForm {

	function set_up(){
		$this->add_search_field();
		$this->add_field("customer_review_status_id", new CustomerReviewStatusField([
			"label" => _("Review status"),
			"empty_choice_text" => "-- "._("any status")." --",
			"required" => false,
		]));
	}
}
