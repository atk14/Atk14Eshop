<?php
class ImportTrackingNumbersForm extends ApplicationForm {
	function set_up() {
		$this->set_button_text(_("Importovat"));
		$this->add_field("service", new ChoiceField(array(
			"label" => _("Doručovací služba"),
			"choices" => array(
				"" => "-- "._("doručovací služba")." --",
				"cp" => _("Česká Pošta"),
				"ppl" => "PPL",
				"geis" => "Geis",
			),
		)));
		$this->add_field("csv_file", new FileField(array(
			"label" => _("Soubor"),
			"help_text" => _("Soubor ve formátu csv s informacemi o podaných zásilkách"),
		)));
	}
}
