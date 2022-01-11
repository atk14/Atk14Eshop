<?php
class EditForm extends RegionsForm {

	function set_up(){
		parent::set_up();

		if($this->controller->region->isDefaultRegion()){
			$this->fields["active"]->disabled = true;
		}
	}
}
