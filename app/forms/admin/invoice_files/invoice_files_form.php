<?php
class InvoiceFilesForm extends AdminForm {

	function set_up(){
		$this->add_field("invoice_no", new CharField([
			"label" => _("Číslo dokladu"),
			"max_length" => 255,
		]));

		$this->add_field("document_date", new DateField([
			"label" => _("Datum vystavení"),
			"required" => false,
			"initial" => Date::Today() 
		]));

		$this->add_field("due_date", new DateField([
			"label" => _("Datum splatnosti"),
			"required" => false,
		]));
	}
}
