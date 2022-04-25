<?php
class TechnicalSpecificationsForm extends AdminForm {

	var $_transformator;

	function set_up(){
		$this->add_field("technical_specification_key_id", new TechnicalSpecificationKeyField(array(
			"label" => _("Key"),
			"disabled" => isset($this->controller->technical_specification_key)
		)));

		if(isset($this->controller->technical_specification_key)){
			$key = $this->controller->technical_specification_key;
			if($this->_transformator = $key->getType()->getTransformator()){
				$this->add_field("content_json",$this->_transformator->getField());
			}
		}

		$this->add_field("content", new CharField(array(
			"label" => _("Text"),
			"trim_value" => true,
			"required" => false,
			"null_empty_output" => true,
		)));

		$this->add_translatable_field("content_localized", new CharField(array(
			"label" => _("Localized text"),
			"trim_value" => true,
			"required" => false,
			"null_empty_output" => true,
		)));
	}

	function set_initial($key_or_values, $value = null){
		if(is_string($key_or_values)){
			$values = array(
				$key_or_values => $value,
			);
		}else{
			$values = $key_or_values;
		}

		$values = is_object($values) ? $values->toArray() : $values;
		if(isset($this->_transformator) && array_key_exists("content_json",$values)){
			$values["content_json"] = $this->_transformator->decodeValue($values["content_json"]);
		}

		return parent::set_initial($values);
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(array_key_exists("content_json",$d)){
			$d["content_json"] = $this->_transformator->encodeValue($d["content_json"]);
		}

		return [$err,$d];
	}
}
