<?php
class DigitalContentsForm extends AdminForm {

	function set_up(){
		$this->add_field("file", new AsyncFileField([
			"label" => _("Soubor"),
			"help_text" => _("Např. pdf soubor.")
		]));

		$this->add_regions_field([
			"help_text" => _("Ve kterých oblastech bude soubor nabízen."),
		]);

		$this->add_field("image_url", new PupiqImageField([
			"label" => _("Ilustrační obrázek"),
			"required" => false,
			"help_text" => _("Pokud nebude nahrán, použije se obrázek od produktu."),
		]));

		$this->add_translatable_field("title", new CharField([
			"label" => _("Název"),
			"required" => false,
		]));

		$this->add_active_field([	
			"label" => _("Je tento soubor dostupný zákazníkům?")
		]);
	}
}
