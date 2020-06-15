<?php

namespace DeliveryService\BranchParser;

class DeliveryServiceBranchData {
	function __construct(\SimpleXMLElement $branch_element) {
		$this->branch_element = $branch_element;
	}
}
