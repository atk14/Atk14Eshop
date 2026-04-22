<?php
class SetRatingForm extends CustomerReviewsForm {

	function set_up(){
		$this->add_field("rating", new RatingField());

		$this->set_hidden_field("rating_submitted",1);

		$this->set_button_text(_("Continue"));
	}
}
