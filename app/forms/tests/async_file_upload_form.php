<?php
class AsyncFileUploadForm extends TestsForm {

	function set_up(){
		$this->add_field("file", new AsyncFileField([
			"label" => _("File #1"),
		]));

		$this->add_field("file2", new AsyncFileField([
			"label" => _("File #2"),
			"required" => false,
		]));

		$this->set_button_text(_("Send file"));
	}
}
