<?php
class CreateNewForm extends CardRecommendationBoostsForm {
	
	function set_up(){
		parent::set_up();
		$this->set_button_text(_("Add product"));
	}
}
