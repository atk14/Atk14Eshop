<?php
class TechnicalSpecificationKey extends ApplicationModel implements Translatable {

	use TraitGetInstanceByCode;

	public static function GetTranslatableFields(){ return array("key_localized"); }

	public static function GetInstanceByKey($key){
		if(!strlen($key)){ return null; }

		($out = self::FindFirst("key=:key",array(":key" => $key))) ||
		($out = self::FindFirst("LOWER(key)=LOWER(:key)",array(":key" => $key)));

		return $out;
	}

	/**
	 * $weight = TechnicalSpecificationKey::GetOrCreateKey("weight"); // nonlocalized key
	 * $weight = TechnicalSpecificationKey::GetOrCreateKey("Weight"); // the same as the previous one
	 */
	public static function GetOrCreateKey($key){
		if(!strlen($key)){ return null; }

		($out = self::GetInstanceByKey($key)) ||
		($out = self::CreateNewRecord(array("key" => $key)));

		return $out;
	}

	function getKey($lang = null){
		global $ATK14_GLOBAL;

		if(is_null($lang)){
			$lang = $ATK14_GLOBAL->getLang();
		}

		if(strlen($key = $this->g("key_localized_$lang"))){
			return $key;
		}

		return $this->g("key");
	}

	function toString(){
		return (string)$this->getKey();
	}

	/***
	 *  list($barvy, $uziti, $material) = TechnicalSpecificationKey::FindByCodes('color', 'width');
	 *  Vrati asociativni pole, kde hodnota null znamena nenalezeno
	 **/
	static function FindByCodes($codes) {
		$ids = self::GetDbMole()->selectIntoAssociativeArray("select code, id from technical_specification_keys where code in :codes", [':codes' => $codes]);
		$cats = static::GetInstanceById($ids);
		$cats = $cats + array_fill_keys($codes, null);
		foreach($codes as &$c) {
			$c = $cats[$c];
		}
		return $codes;
	}

}
