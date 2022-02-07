<?php
class SliderItemsForm extends AdminForm {

	function set_up(){
		$this->add_field("image_url", new PupiqImageField([
			"label" => _("Obrázek"),
		]));

		$this->add_field("small_image_url", new PupiqImageField([
			"label" => _("Malý obrázek"),
			"required" => false,
		]));

		$this->add_translatable_field("title", new CharField([
			"label" => _("Titulek"),
			"required" => false,
			"max_length" => 255,
		]));

		$this->add_translatable_field("description", new TextField([
			"label" => _("Popis"),
			"required" => false,
		]));

		$this->add_field("url", new CharField(array(
			"label" => _("URL / cesta"),
			"required" => false,
			"null_empty_output" => true,
			"help_text" => _("Interní odkaz zadávejte pouze ve formě URI (např. /napoveda/). Odkaz na externí web musí obsahovat celou cestu včetně domény (např. http://www.externi-web.cz/soubor.pdf)."),
		)));

		$this->add_visible_field();

		/*
		$this->add_field("text_color", new RgbaField([
			"label" => _("Barva textu"),
			"initial" => "#ffffff",
		]));

		$this->add_field("background_color", new RgbaField([
			"label" => _("Barva pozadí"),
			"initial" => "rgba(0, 0, 0, 0.5)",
		]));
		*/
	}
}
