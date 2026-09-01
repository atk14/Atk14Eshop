<?php

/**
 * Lightweight proxy for a single category — carries only the fields used by
 * the admin category-tree view.  Replaces a full ORM Category object.
 */
class CategoryLightweightProxy {
	private $data;

	function __construct($data) {
		$this->data = $data;
	}

	function getId()             { return (int)$this->data['id']; }
	function isFilter()          { return $this->_bool($this->data['is_filter']); }
	function isPointingToCategory() { return !is_null($this->data['pointing_to_category_id']); }
	function g($field)           { return $this->_normalize($this->data[$field] ?? null); }

	// PostgreSQL returns booleans as 't'/'f' strings — normalize to PHP bool.
	private function _bool($val)      { return $val === true || $val === 't'; }
	private function _normalize($val) {
		if ($val === 't') { return true; }
		if ($val === 'f') { return false; }
		return $val;
	}

	function getName($lang = null) {
		global $ATK14_GLOBAL;
		$lang = $lang ?: $ATK14_GLOBAL->getLang();
		$visited = [];
		while($lang && !isset($visited[$lang])) {
			$val = $this->data["name_$lang"] ?? null;
			if(strlen((string)$val) > 0) {
				return $val;
			}
			$visited[$lang] = true;
			$langs = $ATK14_GLOBAL->getConfig("locale");
			$lang = $langs[$lang]["fallback"] ?? null;
		}
		return '';
	}

	/**
	 * Only the vehicle tag is precomputed; all other tags return false.
	 * The admin tree template calls containsTag() only for the vehicle tag.
	 */
	function containsTag($tag, $options = []) {
		return (bool)($this->data['has_vehicle_tag'] ?? false);
	}
}
