<?php
class AsyncFileUploadForm extends TestsForm {

	function set_up(){
		$this->add_field("file1", new AsyncFileField([
			"label" => sprintf(_("File #%d"),1),
		]));

		$this->add_field("file2", new AsyncFileField([
			"label" => sprintf(_("File #%d"),2),
			"required" => false,
		]));

		$this->add_field("file3", new FileField([
			"label" => sprintf(_("File #%d"),3)." (not async)",
			"required" => false,
		]));

		$this->set_button_text(_("Send file"));
	}
}
