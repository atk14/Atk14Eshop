<?php
class TechnicalSpecificationKeyType_Base {

	protected $_type;
	protected $_internal_type;
	protected $_label;
	protected $_field_class;

	function __construct($options = []){
		$class = new String4(get_class($this)); // TechnicalSpecificationKeyType_Integer
		$type = $class->gsub('/^.*_/','')->underscore(); // "integer"
		$field_class = $type->camelize()->append("Field"); // "IntegerField"

		$options += [
			"type" => (string)$type,
			"internal_type" => (string)$type,
			"label" => _("Value"),
			"field_class" => (string)$field_class,
		];

		$this->_type = $options["type"];
		$this->_internal_type = $options["internal_type"];
		$this->_label = $options["label"];
		$this->_field_class = $options["field_class"];
	}

	/**
	 *
	 *	$val = $integer_type->decodeValue('{"integer":12}'); // 12
	 *	$val = $integer_type->decodeValue('{"bool":true}'); // true
	 */
	function decodeValue($encoded_json){
		if($encoded_json && ($ar = json_decode($encoded_json,true))){
			$type = $this->_type; // "integer"
			if(isset($ar["$type"])){
				return $ar["$type"];
			}
		}
	}

	/**
	 *
	 *	$val = $integer_type->decodeValueAsString('{"integer":12}'); // "12"
	 *	$val = $integer_type->decodeValueAsString('{"bool":true}'); // "Yes"
	 */
	function decodeValueAsString($encoded_json){
		$value = $this->decodeValue($encoded_json);
		if(is_array($value)){
			return join(", ",$value);
		}
		if(is_bool($value)){
			return $value ? _("Yes") : _("No");
		}
		return (string)$value;
	}

	/**
	 *
	 *	$val = $integer_type->encodeValue(12); // '{"integer":12}'
	 */
	function encodeValue($str_value){
		if(isset($str_value)){
			$type = $this->_type; // "integer", "boolean", "care_instructions"...
			$internal_type = $this->_internal_type; // "integer", "boolean", "array"
			settype($str_value,$internal_type);
			return json_encode(["$type" => $str_value]);
		}
	}

	function shouldBeContentValuePreserved($str_value){
		return true;
	}

	function parseValue($str_value){
		return null;
	}

	function getField($options = []){
		return $this->_getField($this->_field_class,$options);
	}

	function _getField($class_name,$options){
		$options += [
			"label" => $this->_label,
			"required" => true,
		];

		return new $class_name($options);
	}

}
