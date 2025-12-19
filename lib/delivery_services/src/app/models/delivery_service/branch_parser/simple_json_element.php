<?php

namespace DeliveryService\BranchParser;

class SimpleJsonElement implements /*\RecursiveIterator,*/ \ArrayAccess, \Countable {

	public function __construct(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		$this->_data = json_decode($data, true);
	}

	private $_data;
	private $_position = 0;

	protected function getData() {
		return $this->_data;
	}

	#[\ReturnTypeWillChange]
	function offsetGet($offset) {
		return isset($this->_data[$offset]) ? $this->_data[$offset] : null;
	}

	#[\ReturnTypeWillChange]
	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->_data[] = $value;
		} else {
			$this->_data[$offset] = $value;
		}
	}

	#[\ReturnTypeWillChange]
	public function offsetExists($offset) {
		return isset($this->_data[$offset]);
	}

	#[\ReturnTypeWillChange]
	public function offsetUnset($offset) {
		unset($this->_data[$offset]);
	}

	#[\ReturnTypeWillChange]
	public function count() {
		return count($this->_data);
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
