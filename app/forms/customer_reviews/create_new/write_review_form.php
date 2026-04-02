<?php
class WriteReviewForm extends CustomerReviewsForm {

	function set_up(){
		$this->add_field("author", new CharField([
			"label" => _("Your name"),
			"max_length" => 200,
			"help_text" => _("This name will be published")
		]));

		$this->add_field("rating", new RatingField());

		$this->add_field("title", new CharField([
			"label" => _("Review title"),
			"max_length" => 200,
		]));

		$f = $this->add_field("body", new TextField([
			"label" => _("Your review"),
			"max_length" => 2000,
		]));
		$f->update_message("required",_("Write a few words about your rating"));

		$this->set_hidden_field("review_submitted",1);

		$this->set_button_text(_("Save review"));
	}
}
