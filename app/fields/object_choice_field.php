<?php
/**
 * Bazova trida pro dalsi ChoiceField, ve kterych se vybira objekt dane tridy
 *
 *	PersonField extends ObjectChoiceField{ }
 *
 *	PersonField extends ObjectChoiceField{
 *		function __construct($options = []){
 *			$options + [
 *				"order_by" => "UPPER(lastname)||UPPER(firstname)"
 *			];
 *			parent::__construct($options);
 *		}
 *	}
 */
class ObjectChoiceField extends ChoiceField {

	var $class_name;
	var $conditions;
	var $bind_ar;
	var $order_by;

	function __construct($options = []){
		$options += [
			"class_name" => null,
			"order_by" => null,
			"conditions" => [],
			"bind_ar" => [],
			"empty_choice_text" => "",

			"value_formatter" => function($object){
				return (string)$object;
			}
		];

		if($options["class_name"]){
			$this->class_name = $options["class_name"];
		}
		unset($options["class_name"]);
		if(!$this->class_name){
			$this->class_name = String4::ToObject(get_class($this))->gsub('/Field$/','')->toString(); // PersonField -> Person
		}

		if($options["order_by"]){
			$this->order_by = $options["order_by"];
		}
		unset($options["order_by"]);
		if(!$this->order_by){
			$this->order_by = "id";
		}

		$this->conditions = $options["conditions"];
		unset($options["conditions"]);

		$this->bind_ar = $options["bind_ar"];
		unset($options["bind_ar"]);

		$choices = ["" => $options["empty_choice_text"]];
		unset($options["empty_choice_text"]);
		$formatter = $options["value_formatter"];
		unset($options["value_formatter"]);
		foreach($this->get_objects() as $o){
			$choices[$o->getId()] = $formatter($o);
		}

		$options["choices"] = $choices;

		parent::__construct($options);
	}

	function format_initial_data($value){
		return is_object($value) ? $value->getId() : $value;
	}

	function get_objects(){
		$class = $this->class_name;
		return $class::FindAll(["order_by" => $this->order_by]);
	}

	function clean($value){
		list($err,$value) = parent::clean($value);
		if(!is_null($err) || is_null($value)){ return [$err,$value]; }

		$value = Cache::Get("$this->class_name",$value);
		myAssert($value);

		return [null,$value];
	}
}
