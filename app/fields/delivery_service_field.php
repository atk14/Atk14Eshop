<?php
class DeliveryServiceField extends ObjectChoiceField {

	function __construct($options = array()){
		$options += [
			"label" => _("Service providing pickup points"),
			"help_text" => join("<br>", [
				_("Service providing customers possibility to choose a pickup point."),
				_("Some additional setup may be required."),
			]),

			"order_by" => "rank,id",
			"value_formatter" => function($object){
				$id = $object->getId();
				$title = $object->getName();
				$requirements = $object->getRequirements();
				if ($requirements) {
					$requirements = sprintf(_("requires: %s"), join(", ", array_keys($requirements)));
					$title = sprintf("%s [%s]", $title, $requirements);
				}
				return $title;
			}
		];
		parent::__construct($options);
	}
}
