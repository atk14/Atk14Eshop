<?php
class EditForm extends ProductTypesForm {

	function set_up(){
		parent::set_up();

		if($this->controller->product_type->getCode()=="default"){
			$this->fields["code"]->disabled = true;
		}
	}
}
