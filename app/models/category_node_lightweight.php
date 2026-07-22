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
		return $this->data["name_$lang"] ?? $this->data['name_cs'] ?? '';
	}

	/**
	 * Only the vehicle tag is precomputed; all other tags return false.
	 * The admin tree template calls containsTag() only for the vehicle tag.
	 */
	function containsTag($tag, $options = []) {
		return (bool)($this->data['has_vehicle_tag'] ?? false);
	}
}

/**
 * Lightweight iterable node for the admin category tree.
 * Shares a single $nodes and $children array (by reference) across all nodes
 * so no data is duplicated in memory.
 */
class CategoryNodeLightweight implements IteratorAggregate, Countable {
	private $category_id;
	private $nodes;
	private $children;

	function __construct($category_id, &$nodes, &$children) {
		$this->category_id = $category_id;
		$this->nodes = &$nodes;
		$this->children = &$children;
	}

	function getCategory() {
		return new CategoryLightweightProxy($this->nodes[$this->category_id]);
	}

	function hasChildCategories() {
		return !empty($this->children[(string)$this->category_id]);
	}

	#[\ReturnTypeWillChange]
	function count() {
		return count($this->children[(string)$this->category_id] ?? []);
	}

	#[\ReturnTypeWillChange]
	function getIterator() {
		$out = [];
		foreach (($this->children[(string)$this->category_id] ?? []) as $child_id) {
			$out[] = new CategoryNodeLightweight($child_id, $this->nodes, $this->children);
		}
		return new ArrayIterator($out);
	}
}
