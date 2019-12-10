<?php
class Creator extends ApplicationModel implements Translatable {

	static function GetTranslatableFields(){ return ["name_localized"]; } // good for e.g. "team of authors" in english, "kolektiv autoru" in czech

	static function GetInstanceByName($name){
		$name = trim($name);
		return self::FindFirst([
			"conditions" => [
				"LOWER(name)=LOWER(:name)"
			],
			"bind_ar" => [
				":name" => $name,
			]
		]);
	}

	function getName($lang = null){
		global $ATK14_GLOBAL;

		if(is_null($lang)){
			$lang = $ATK14_GLOBAL->getLang();
		}

		if(strlen($name = $this->g("name_localized_$lang"))){
			return $name;
		}

		return $this->g("name");
	}

	function getPage(){
		return Cache::Get("Page",$this->getPageId());
	}

	function toHumanReadableString(){
		return $this->g("name");
	}

	function toString(){
		return (string)$this->getName();
	}
}
