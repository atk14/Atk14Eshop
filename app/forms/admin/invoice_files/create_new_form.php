<?php
class CreateNewForm extends InvoiceFilesForm {

	function set_up(){
		$this->add_field("file", new FileField([
			"label" => _("Soubor"),
		]));

		parent::set_up();

		$this->fields["invoice_no"]->required = false; // see method clean()
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(!$this->has_errors()){
			if(!strlen($d["invoice_no"])){
				$d["invoice_no"] = String4::ToObject($d["file"]->getFileName())->gsub('/\.[^.]*$/','')->gsub('/[_]/',' ')->gsub('/\s+/',' ')->trim()->toString(); // "FV_12345.pdf" -> "FV 12345"
			}
		}

		return array($err,$d);
	}
}
