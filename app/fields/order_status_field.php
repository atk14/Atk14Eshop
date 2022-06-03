<?php
class OrderStatusField extends ChoiceField {

	function __construct($options = []){

		$choices = [
			"" => sprintf("-- %s --", _("stav objednávky")),
		];
		foreach(OrderStatus::FindAll() as $os){
			$icon = "";
			$label = $os->getName();
			if($os->finishedSuccessfully()){
				$icon = "✅"; // green-heavy-check-mark (&#9989;)
			}elseif($os->isFinishingSuccessfully()){
				$icon = "✓"; // black check (&#10003;)
			}elseif($os->finishedUnsuccessfully()){
				$icon = "❌"; // red cross check
			}elseif($os->isFinishingUnsuccessfully()){
				$icon = "𐄂"; // black cross check
			}
			$icon = strlen($icon) ? "$icon " : html_entity_decode("&nbsp;&nbsp;&nbsp;");
			$choices[$os->getId()] = $icon.$label;
		}
		$options["choices"] = $choices;

		parent::__construct($options);
	}
}
