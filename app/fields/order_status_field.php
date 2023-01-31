<?php
class OrderStatusField extends ChoiceField {

	function __construct($options = []){

		$choices = [
			"" => sprintf("-- %s --", _("stav objednávky")),
		];
		foreach(OrderStatus::FindAll() as $os){
			$icon = "";
			$label = $os->getName();
			if($os->isFinishingSuccessfully() || $os->finishedSuccessfully()){
				$icon = "✅ ";
			}elseif($os->isFinishingUnsuccessfully() || $os->finishedUnsuccessfully()){
				$icon = "❌ ";
			}
			$choices[$os->getId()] = $icon.$label;
		}
		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
