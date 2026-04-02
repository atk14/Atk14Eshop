<?php
class RatingField extends IntegerField {

	function __construct($options = []){
		parent::__construct([
			"label" => _("Rating"),
			"min_value" => 1,
			"max_value" => CustomerReview::MAX_RATING,
		]);

		$this->update_message("required",_("Select the number of stars that corresponds to your level of satisfaction, with a scale being one to five stars"));
	}
}
