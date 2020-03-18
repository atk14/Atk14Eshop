<?php
class EditForm extends DigitalContentsForm {

	function set_up(){
		parent::set_up();
		unset($this->fields["file"]);
	}
}
