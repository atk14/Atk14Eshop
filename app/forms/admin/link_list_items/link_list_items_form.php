<?php
class LinkListItemsForm extends AdminForm {

	function set_up() {
		$this->add_translatable_field("label", new CharField(array(
			"label" => _("Zobrazený text"),
		)));

		$this->add_field("url", new CharField(array(
			"label" => _("URL / cesta"),
			"required" => false,
			"help_text" => _("Interní odkaz zadávejte pouze ve formě URI (např. /napoveda/). Odkaz na externí web musí obsahovat celou cestu včetně domény (např. http://www.externi-web.cz/soubor.pdf). Nevyplněné URL znemená, že se zobrazí jen text bez odkazu - na kliknutí nebude reagováno."),
		)));

		$this->add_field("image_url", new PupiqImageField([
			"label" => _("Obrázek"),
			"required" => false,
			"help_text" => _("V některých případech může být hezké, když je u odkazu nějaký obrázek."),
		]));

		$this->add_field("regions", new RegionsField(array(
			"label" => _("Zobrazovat v oblasti"),
			"json_encode" => true,
		)));
	}
}
