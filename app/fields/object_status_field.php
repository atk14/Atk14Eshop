<?php
class ObjectStatusField extends ChoiceField {

	var $class_name;

	function __construct($options = []){

		$options += [
			"class_name" => String4::ToObject(get_class($this))->gsub('/Field$/','')->toString(), // "OrderStatusField" -> "OrderStatus"
			"empty_choice_text" => sprintf("-- %s --", _("status")),
		];

		$class_name = $options["class_name"];
		$this->class_name = $class_name;

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

	function clean($value){
		list($err,$id) = parent::clean($value);
		if(is_null($id) || !is_null($err)){ return [$err,$id]; }

		$status_object = Cache::Get($this->class_name,$id);
		return [null,$status_object];
	}
}
