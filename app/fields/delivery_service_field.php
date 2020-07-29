<?php
class DeliveryServiceField extends ObjectChoiceField {

	function __construct($options = array()){
		$options += [
			"order_by" => "rank,id",
			"value_formatter" => function($object){
				$id = $object->getId();
				$title = $object->getName();
				return $title;
			}
		];
		parent::__construct($options);
	}
}
