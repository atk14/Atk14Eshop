<?php

trait TraitCodebook {

	static $ByCodes = null;
	static $ByIds = null;

	static function _PrereadCache($options) {
		if(static::$ByIds !== null && (!isset($options['force_read']) || !$options['force_read'])) {
			return;
		}
		$all = static::FindAll(['use_cache' => false]);
		static::$ByCodes = [];
		static::$ByIds = [];
		foreach($all as $a) {
			static::$ByCodes[$a->getCode()] = $a;
			static::$ByIds[$a->getId()] = $a;
		}
	}

	static function FindById($id, $options=[]) {
		static::_PrereadCache($options);
		$f = function($id) { return isset(static::$ByIds[$id])?static::$ByIds[$id]:null;};
		if(is_array($id)) {
			$out=array_map($f, $id);
			return $out;
		} else {
			return $f($id);
		}
	}

	static function FindByCode($id, $options=[]) {
		static::_PrereadCache($options);
		$f = function($id) {return isset(static::$ByCodes[$id])?static::$ByCodes[$id]:null;};
		if(is_array($id)) {
			return array_map($f, $id);
		} else {
			return $f($id);
		}
	}

	static function GetInstanceById($id, $options=[]) {
		return static::FindById($id, $options);
	}

	static function GetInstanceByCode($id, $options=[]) {
		return static::FindByCode($id, $options);
	}
}
