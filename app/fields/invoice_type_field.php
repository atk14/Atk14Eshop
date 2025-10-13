<?php
class InvoiceTypeField extends ChoiceField {

	function __construct($options = []){
		$choices = [
			"" => "",
			InvoiceFile::TYPE_INVOICE => _("Faktura"),
			InvoiceFile::TYPE_STORNO => _("Storno faktura"),
			InvoiceFile::TYPE_PROFORMA => _("Proforma faktura"),
		];
		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
