<?php
class ObjectStatusField extends ChoiceField {

	function __construct($options = []){

		$options += [
			"class_name" => String4::ToObject(get_class($this))->gsub('/Field$/','')->toString(), // "OrderStatusField" -> "OrderStatus"
			"empty_choice_text" => sprintf("-- %s --", _("status")),
		];

		$class_name = $options["class_name"];

		$choices = [
			"" => $options["empty_choice_text"],
		];
		foreach($class_name::FindAll() as $os){
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
