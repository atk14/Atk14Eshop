<?php
class DetailForm extends ApiForm {
	function set_up() {
		$this->add_field("zip", new PostOfficeField());
	}
}
