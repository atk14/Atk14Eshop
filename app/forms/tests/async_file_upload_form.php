<?php
class AsyncFileUploadForm extends TestsForm {

	function set_up(){
		$this->add_field("file", new AsyncFileField([
			"label" => _("Soubor"),
		]));

		$this->set_button_text(_("Send file"));
	}
}
