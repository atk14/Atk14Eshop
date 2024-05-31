<?php
class ProductTypesForm extends AdminForm {

	function set_up(){
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Title"),
			"max_legth" => 255,
			"hint" => _("kniha, film, album, motorka...")
		)));

		$placeholders = "<ul>";
		foreach(array(
			"%product_name%" => _("název produktu"),
			"%main_creators%" => _("seznam hlavních tvůrců (např. autor knihy)"),
			"%catalog_id%" => _("kód produktu"),
		) as $placeholder => $description){
			$placeholders .= "<li><strong>$placeholder</strong> - $description</li>";
		}
		$placeholders .= "</ul>";

		$this->add_translatable_field("page_title_pattern", new CharField(array(
			"label" => _("Vzor pro generování názvu stránky"),
			"max_legth" => 255,
			"help_text" => _("Lze použít následující zástupné značky:").$placeholders,
			"initial" => "%product_name%"
		)));

		$this->add_code_field();

		$this->add_slug_field();
	}
}
