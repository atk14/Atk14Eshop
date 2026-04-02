<?php
class PaymentMethodField extends ObjectChoiceField {
	
	function __construct($options = array()){
		$options += [
			"order_by" => "rank,id",
			"value_formatter" => function($object){
				$id = $object->getId();
				$regions = $object->getRegions();
				$regions = array_map(function($region){ return $region->getShortcut(); }, $regions);
				$title = "[".join(", ",$regions)."] ";
				$title .= $object->getLabel();
				if(!$object->isActive()){
					$title .= " ("._("neaktivní").")";
				}
				return $title;
			}
		];
		parent::__construct($options);
	}
}
