<?php
/**
 * Trait for small tables with unique field "code"
 *
 * All records are being loaded automatically into memory during first usage.
 * Methods FindById(), FindByCode(), GetInstanceById() and GetInstanceByCode() return records from memory.
 */
trait TraitCodebook {

	static $ByCodes = null;
	static $ByIds = null;

	static function _PrereadCache($options) {
		if(static::$ByIds !== null && (!isset($options['force_read']) || !$options['force_read'])) {
			return;
		}
		$all = static::FindAll(['use_cache' => true]);
		static::$ByCodes = [];
		static::$ByIds = [];
		foreach($all as $a) {
			if(strlen((string)$a->getCode())){
				static::$ByCodes[$a->getCode()] = $a->getId();
			}
			static::$ByIds[$a->getId()] = $a->getId();
		}
	}

	static function FindById($id, $options = []) {
		static::_PrereadCache($options);
		$id = is_object($id) ? $id->getId() : $id;
		$class_name = get_called_class();
		return isset(static::$ByIds[$id]) ? Cache::Get($class_name,static::$ByIds[$id]) : null;
	}

	static function FindByCode($code, $options = []) {
		static::_PrereadCache($options);
		$class_name = get_called_class();
		return isset(static::$ByCodes[$code]) ? Cache::Get($class_name,static::$ByCodes[$code]) : null;
	}

	static function GetInstanceById($id, $options = []) {
		if(!is_array($id)){
			return static::FindById($id, $options);
		}
		return parent::GetInstanceById($id, $options);
	}

	static function GetInstanceByCode($code, $options = []) {
		return static::FindByCode($code, $options);
	}
}
