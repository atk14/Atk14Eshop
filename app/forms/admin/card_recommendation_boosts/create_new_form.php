<?php
class CreateNewForm extends CardRecommendationBoostsForm {

	function set_up() {
		$this->add_field("card", new CardField(array(
			"label" => _("Product")
		)));

		$this->set_button_text(_("Add product"));
	}
}
