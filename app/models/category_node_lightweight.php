<?php

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

	private function _realId() {
		return (string)($this->nodes[$this->category_id]['real_id'] ?? $this->category_id);
	}

	function hasChildCategories() {
		return !empty($this->children[$this->_realId()]);
	}

	#[\ReturnTypeWillChange]
	function count() {
		return count($this->children[$this->_realId()] ?? []);
	}

	#[\ReturnTypeWillChange]
	function getIterator() {
		$out = [];
		foreach (($this->children[$this->_realId()] ?? []) as $child_id) {
			$out[] = new CategoryNodeLightweight($child_id, $this->nodes, $this->children);
		}
		return new ArrayIterator($out);
	}
}
