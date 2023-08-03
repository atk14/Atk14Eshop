<?php
class TechnicalSpecificationKey extends ApplicationModel implements Translatable, Rankable {

	protected static $CacheKeys;

	use TraitGetInstanceByCode;

	public static function GetTranslatableFields(){ return array("key_localized"); }

	public static function GetInstanceByKey($key){
		if(!strlen($key)){ return null; }

		if(is_null(self::$CacheKeys)){
			$dbmole = self::GetDbmole();
			self::$CacheKeys = $dbmole->selectIntoAssociativeArray("SELECT key,id FROM technical_specification_keys");
		}

		if(isset(self::$CacheKeys[$key])){
			return Cache::Get("TechnicalSpecificationKey",self::$CacheKeys[$key]);
		}
		foreach(self::$CacheKeys as $k => $id){
			if(Translate::Lower($k)===Translate::Lower($key)){
				return Cache::Get("TechnicalSpecificationKey",$id);
			}
		}
	}

	/**
	 * $weight = TechnicalSpecificationKey::GetOrCreateKey("weight"); // nonlocalized key
	 * $weight = TechnicalSpecificationKey::GetOrCreateKey("Weight"); // the same as the previous one
	 */
	public static function GetOrCreateKey($key){
		if(!strlen($key)){ return null; }

		if($out = self::GetInstanceByKey($key)){
			return $out;
		}
		
		$out = self::CreateNewRecord(array("key" => $key));
		static::$CacheKeys = null;
		return $out;
	}

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getKey($lang = null){
		global $ATK14_GLOBAL;

		if(is_null($lang)){
			$lang = $ATK14_GLOBAL->getLang();
		}

		if(strlen($key = (string)$this->g("key_localized_$lang"))){
			return $key;
		}

		return $this->g("key");
	}

	function isVisible(){ return $this->getVisible(); }

	function getTechnicalSpecificationKeyType(){
		return Cache::Get("TechnicalSpecificationKeyType",$this->getTechnicalSpecificationKeyTypeId());
	}

	// Alias
	function getType(){
		return $this->getTechnicalSpecificationKeyType();
	}

	function isDeletable(){
		if(strlen($this->getCode())>0){
			return false;
		}
		if($this->getTechnicalSpecificationKeyType()->getCode()!=="text"){
			return false;
		}
		$count = $this->dbmole->selectInt("
			SELECT COUNT(*) FROM
				technical_specifications, cards
			WHERE
				technical_specifications.technical_specification_key_id=:key AND
				cards.id=technical_specifications.card_id AND
				NOT cards.deleted
		",[":key" => $this]);
		return $count === 0;
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
