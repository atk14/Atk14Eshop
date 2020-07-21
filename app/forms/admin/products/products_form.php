<?php
class ProductsForm extends AdminForm {

	function set_up() {
		$this->add_field("catalog_id", new CatalogIdField(array(
			"label" => _("Catalog number"),
		)));
		$this->add_vat_rate_id_field();
		$this->add_unit_id_field();
		$this->add_consider_stockcount_field();
		$this->add_translatable_field("label", new CharField(array(
			"label" => _("Variant name"),
			"hints" => array("XL","20ml","1kg","32GB"),
			"required" => true,
		)));
		$this->add_translatable_field("name", new CharField(array(
			"label" => _("Product name"),
			"required" => false,
			"help_text" => _("Fill in only when product name differs from it's card name"),
		)));
		$this->add_translatable_field("description", new MarkdownField(array(
			"label" => _("Description"),
			"required" => false,
		)));
		$this->add_field("tags", new TagsField(array(
			"label" => _("Tags"),
			"required" => false,
			"create_missing_tags" => false,
			"help_text" => _("Obvykle postačí definovat štítky pouze na produktové kartě. Zde je však možnost doplnit k této produktové variantě štítky, které na kartě chybí a nemohou být přidány."),
		)));
		$this->add_visible_field(array(
			"label" => _("Is product variant visible?"),
		));
	}
}
