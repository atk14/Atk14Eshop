<?php
class EditForm extends CustomerGroupsForm {

	function set_up(){
		parent::set_up();

		if(!$this->controller->customer_group->isManuallyAssignable()){
			$this->disable_fields(["code"]);
		}
	}
}
