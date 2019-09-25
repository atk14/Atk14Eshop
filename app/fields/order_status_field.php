<?php
class OrderStatusField extends ChoiceField {

	function __construct($options = []){

		$choices = [
			"" => sprintf("-- %s --", _("stav objednávky")),
		];
		foreach(OrderStatus::FindAll() as $os){
			$label = $os->getName();
			$choices[$os->getId()] = $label;
		}
		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
