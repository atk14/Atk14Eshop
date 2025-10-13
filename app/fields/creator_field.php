<?php
class CreatorField extends ObjectField {

	protected $profile_sign = "👁"; // Eye, https://www.compart.com/en/unicode/U+1F441
	
	function __construct($options = []){
		$options += [
			"create_creator_if_not_found" => false,
		];

		$this->create_creator_if_not_found = $options["create_creator_if_not_found"];

		parent::__construct($options);
	}

	function format_initial_data($value){
		$value = parent::format_initial_data($value);
		if(preg_match('/\[#(\d+)\]$/',$value,$matches)){
			$id = $matches[1];
			$creator = Cache::Get("Creator",$id);
			if($creator && !is_null($creator->getPageId())){
				$value = $this->profile_sign." ".$value; // "John Doe [#123]" -> "* John Doe [#123]"
			}
		}
		return $value;
	}

	function clean($value){
		$value = str_replace($this->profile_sign,"",$value); // "* John Doe [#123]" -> " John Doe [#123]"
		$value = trim($value);

		if(strlen($value) && !is_numeric($value) && !preg_match('/\[#\d+\]$/',$value)){ // "John Doe [#123]"
			$creator = Creator::GetInstanceByName($value);
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
