<?php
class TechnicalSpecificationKeysForm extends AdminForm {

	function set_up(){
		$this->add_field("key", new CharField(array(
			"label" => _("Key"),
			"max_length" => 255,
		)));

		$this->add_code_field();

		$this->add_visible_field();

		$this->add_field("technical_specification_key_type_id", new TechnicalSpecificationKeyTypeField(array(
			"label" => _("Key type"),
			"initial" => TechnicalSpecificationKey::GetInstanceByCode("text"),
			"help_text" => _("The key type cannot be changed at this place"),
			"required" => true,
			"disabled" => true,
		)));

		$this->add_translatable_field("key_localized", new CharField(array(
			"label" => _("Lokalizovaný název"),
			"required" => false,
		)));
	}
}
