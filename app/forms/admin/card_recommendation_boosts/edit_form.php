<?php
class EditForm extends CardRecommendationBoostsForm {
	
	function set_up(){
		parent::set_up();
		$this->fields["card_id"]->disabled = true;
		$this->set_button_text(_("Update"));
	}
}
