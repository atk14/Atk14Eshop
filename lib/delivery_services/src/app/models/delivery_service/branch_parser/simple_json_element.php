<?php

namespace DeliveryService\BranchParser;

class SimpleJsonElement implements /*\RecursiveIterator,*/ \ArrayAccess {

	public function __construct(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		$this->_data = json_decode($data, true);
	}

	public function _getBranchNodes($options=[]) {
#		$_branch_element_name = sprintf("//%s%s", ($nsPrefix ? $nsPrefix.":" : ""), $static::GetXMLBranchName());

		return array_map(function($e) {
			return new static(json_encode($e));
		}, $this->_data["data"]["destination"]);
	}

	private $_data;
	private $_position = 0;

	protected function getData() {
		return $this->_data;
	}

	function offsetGet($offset): mixed {
		return isset($this->_data[$offset]) ? $this->_data[$offset] : null;
	}

	public function offsetSet($offset, $value): void {
		if (is_null($offset)) {
			$this->_data[] = $value;
		} else {
			$this->_data[$offset] = $value;
		}
	}

	public function offsetExists($offset): bool {
		return isset($this->_data[$offset]);
	}

	public function offsetUnset($offset): void {
		unset($this->_data[$offset]);
	}


	/** RecursiveIterator Methods */

	/*
	public function getChildren() {
		return $this->_data[$this->_position];
	}
	public function hasChildren(): bool {
		return is_array($this->_data[$this->_position]);
	}
	 */

	/* Inherited methods */

	/*
	public function current(): mixed {
		return new static(json_encode($this->_data[$this->_position]));
	}
	public function key(): mixed {
		return $this->_position;
	}
	public function next(): void {
		$this->_position++;
	}
	public function rewind(): void {
		$this->_position = 0;
	}
	public function valid(): bool {
		return isset($this->_data[$this->_position]);
	}
	 */
}
