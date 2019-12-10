<?php
class EditForm extends CardCreatorsForm {

	function set_up(){
		parent::set_up();
		$this->fields["creator_id"]->disabled = true;
	}
}
