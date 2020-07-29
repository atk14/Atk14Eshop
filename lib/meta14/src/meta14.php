<?php

class Meta14 {

	protected $items = [];

	const META_TYPE_NAME = "name";
	const META_TYPE_HTTP_EQUIV = "http-equiv";
	const META_TYPE_PROPERTY = "property";

	function __construct() {
	}

	/**
	 * Sets basic single type meta tag
	 *
	 * Only last value is print out.
	 *
	 * Example
	 * ```
	 * $meta14->setMeta("keywords", "keyword1, keyword2");
	 * $meta14->setMeta("keywords", "buzzword1, buzzword2");
	 * ```
	 * Result
	 * ```
	 * <meta name="keywords" content="buzzword1, buzzword2">
	 * ```
	 */
	function setMeta($key, $value, $type=self::META_TYPE_NAME) {
		if (!array_key_exists($type, $this->items)) {
			$this->items[$type] = [];
		}
		if (!array_key_exists($key, $this->items[$type])) {
			$this->items[$type][$key] = [];
		}
		$this->items[$type][$key] = $value;
	}

	/**
	 * Adds basic multiple type meta tag
	 *
	 * Example
	 * ```
	 * $meta14->addMeta("google-site-verification", "googlekey1");
	 * $meta14->addMeta("google-site-verification", "googlekey2");
	 * ```
	 * Result
	 * ```
	 * <meta name="google-site-verification" content="googlekey1">
	 * <meta name="google-site-verification" content="googlekey2">
	 * ```
	 */
	function addMeta($key, $value, $type=self::META_TYPE_NAME) {
		if (!array_key_exists($type, $this->items)) {
			$this->items[$type] = [];
		}
		if (!array_key_exists($key, $this->items[$type])) {
			$this->items[$type][$key] = [];
		}
		if ($this->items[$type][$key] && !is_array($this->items[$type][$key])) {
			settype($this->items[$type][$key], "array");
		}
		$this->items[$type][$key][] = $value;
	}

	function setProperty($key, $value) {
		return $this->setMeta($key, $value, self::META_TYPE_PROPERTY);
	}

	function addProperty($key, $value) {
		return $this->addMeta($key, $value, self::META_TYPE_PROPERTY);
	}

	function addHttpEquiv($key, $value) {
		return $this->addMeta($key, $value, self::META_TYPE_HTTP_EQUIV);
	}

	function getItems() {
		return $this->items;
	}
}
