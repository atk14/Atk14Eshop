<?php

/**
 * Support pro <head> tagy.
 *
 * meta tag <meta>
 * ```
 * $tags->addMetaTag("keywords", "Eshop, skelet, Atk14");
 * $tags->addMetaTag("google-site-verification", "googlekey1");
 * ```
 * Outputs:
 * ```
 * <meta name="keywords" content="Eshop, skelet, Atk14">
 * <meta name="google-site-verification" content="googlekey1">
 * ```
 *
 * ```
 * $tags->addHttpEquiv("content-language", "en");
 * ```
 * equals
 * ```
 * $tags->addMetaTag("content-language", "en", self::META_TYPE_HTTP_EQUIV);
 * ```
 * outputs:
 * <meta http-equiv="content-language" content="en">
 * ```
 * ```
 *
 * link tag <link>
 * ```
 * $tags->addLinkTag("stylesheet", ["href" => "https://atk14eshop.com/stylesheets/main.css"]);
 * ```
 */

class HeadTags14 {

	protected $items = [];
	protected $links = [];

	const META_TYPE_CHARSET = "charset";
	const META_TYPE_HTTP_EQUIV = "http-equiv";
	const META_TYPE_NAME = "name";
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
	 * $meta14->setMetaTag("keywords", "keyword1, keyword2");
	 * $meta14->setMetaTag("keywords", "buzzword1, buzzword2");
	 * ```
	 * Result
	 * ```
	 * <meta name="keywords" content="buzzword1, buzzword2">
	 * ```
	 */
	function setMetaTag($key, $content, $type=self::META_TYPE_NAME) {
		if (!array_key_exists($type, $this->items)) {
			$this->items[$type] = [];
		}
		if (!array_key_exists($key, $this->items[$type])) {
			$this->items[$type][$key] = [];
		}
		$this->items[$type][$key] = new MetaTag14($type, $key, $content);
	}

	/**
	 * Adds basic multiple type meta tag
	 *
	 * Example
	 * ```
	 * $meta14->addMetaTag("google-site-verification", "googlekey1");
	 * $meta14->addMetaTag("google-site-verification", "googlekey2");
	 * ```
	 * Result
	 * ```
	 * <meta name="google-site-verification" content="googlekey1">
	 * <meta name="google-site-verification" content="googlekey2">
	 * ```
	 * @param string $attribute_value
	 * @param string $content
	 */
	function addMetaTag($attribute_value, $content, $type=self::META_TYPE_NAME) {
		if (!array_key_exists($type, $this->items)) {
			$this->items[$type] = [];
		}
		if (!array_key_exists($attribute_value, $this->items[$type])) {
			$this->items[$type][$attribute_value] = [];
		}
		if ($this->items[$type][$attribute_value] && !is_array($this->items[$type][$key])) {
			settype($this->items[$type][$attribute_value], "array");
		}
		$this->items[$type][$attribute_value][] = new MetaTag14($type, $key, $content);
	}

	/**
	 * Shortcut for unofficial property meta tag.
	 *
	 * ```
	 * <meta property="og:type" content="website">
	 * ```
	 */
	function setProperty($attribute_value, $content) {
		return $this->setMetaTag($attribute_value, $content, self::META_TYPE_PROPERTY);
	}

	function addProperty($attribute_value, $content) {
		return $this->addMetaTag($attribute_value, $content, self::META_TYPE_PROPERTY);
	}

	/**
	 * Shortcut for http-equiv meta tag.
	 *
	 * ```
	 * <meta http-equiv="content-language" content="en">
	 * ```
	 */
	function addHttpEquiv($attribute_value, $value) {
		return $this->addMetaTag($attribute_value, $value, self::META_TYPE_HTTP_EQUIV);
	}

	/**
	 * Shortcut for meta charset tag.
	 *
	 * ```
	 * <meta charset="utf-8">
	 * ```
	 */
	function setCharsetMeta($charset) {
		return $this->setMetaTag($charset, null, self::META_TYPE_CHARSET);
	}

	function getItems() {
		return $this->items;
	}

	/**
	 * ```
	 * $header14->addLinkTag("preconnect", ["href" => "//images.atk14eshop.net"]);
	 * $header14->addLinkTag("preconnect", ["href" => "//fonts.atk14eshop.net"]);
	 * ```
	 * Output:
	 * ```
	 * <link rel="preconnect" href="//images.atk14eshop.net">
	 * <link rel="preconnect" href="//fonts.atk14eshop.net">
	 * ```
	 */
	function addLinkTag($rel, $attributes) {
		if (!array_key_exists($rel, $this->links)) {
			$this->links[$rel] = [];
		}
		if (!is_array($this->links[$rel])) {
			settype($this->links[$rel], "array");
		}
		$this->links[$rel][] = new LinkTag14($rel, $attributes);
	}

	function getLinkTags() {
		return $this->links;
	}

	/**
	 * Special set methods to set important link tags.
	 */
	function setCanonical($canonical_url) {
		$this->links["canonical"] = [new LinkTag14("canonical", ["href" => $canonical_url])];
	}
}

class Element14 {
	function getData() {
		return $this->data;
	}
}

class MetaTag14 extends Element14 {
	function __construct($meta_type, $key, $data) {
		$this->meta_type = $meta_type;
		$this->key = $key;
		$this->data = $data;
	}

	function __toString() {
		$_attrs = [];
		$_attrs[] = sprintf('%s="%s"', $this->meta_type, $this->key);
		if (!is_null($_data = $this->getData())) {
			$_attrs[] = sprintf('content="%s"', $_data);
		}
		return sprintf('<meta %s>', join(" ", $_attrs));
	}
}

class LinkTag14 extends Element14 {
	function __construct($rel_type,$attributes) {
		$this->rel_type = $rel_type;
		$this->data = $attributes;
	}

	function __toString() {
		$_attrs = [];
		$_attrs[] = sprintf('rel="%s"', $this->rel_type);
		foreach($this->getData() as $key => $value) {
			$_attrs[] = sprintf('%s="%s"', $key, $value);
		}
		return sprintf('<link %s>', join(" ", $_attrs));
	}
}
