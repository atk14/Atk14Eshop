<?php
class CreatorField extends ObjectField {
	
	function __construct($options = []){
		$options += [
			"create_creator_if_not_found" => false,
		];

		$this->create_creator_if_not_found = $options["create_creator_if_not_found"];

		parent::__construct($options);
	}

	function clean($value){
		$value = trim($value);

		if(strlen($value) && !is_numeric($value) && !preg_match('/\[#\d+\]$/',$value)){ // "John Doe [#123]"
			$creator = Creator::FindFirst([
				"conditions" => [
					"LOWER(name)=LOWER(:name)",
				],
				"bind_ar" => [":name" => $value],
			]);
			if(!$creator && $this->create_creator_if_not_found){
				$creator = Creator::CreateNewRecord([
					"name" => $value,
				]);
			}
			if($creator){
				$value = sprintf("%s [#%d]",$creator->toHumanReadableString(),$creator->getId());
			}
		}

		return parent::clean($value);
	}
}
