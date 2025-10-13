<?php
class SliderItemsForm extends AdminForm {

	function set_up(){
		$this->add_field("image_url", new PupiqImageField([
			"label" => _("Obrázek"),
			"help_text" => _("Ořezává se automaticky na poměr stran 3:1.")
		]));

		$this->add_field("small_image_url", new PupiqImageField([
			"label" => _("Malý obrázek"),
			"required" => false,
			"help_text" => _("Zobrazí se na malých displejích pouze pokud není vyplněn žádný text (ořezává se na poměr stran 1:1,15 a 1:1).")
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

		$this->add_field("display_from", new DateTimeField([
			"label" => _("Display this picture from date and time"),
			"hints" => [
				Atk14Locale::FormatDateTime(now()),
				Atk14Locale::FormatDateTime(Date::Today()->plusMonth()->getMonthFirstDay()." 00:00"),
			],
			"required" => false,
		]));

		$this->add_field("display_to", new DateTimeField([
			"label" => _("Display this picture to date and time"),
			"hints" => [
				Atk14Locale::FormatDateTime(Date::Today()->getMonthLastDay()." 23:59"),
			],
			"required" => false,
		]));

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
