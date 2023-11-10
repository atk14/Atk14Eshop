<?php

namespace DeliveryService\BranchParser;

class DeliveryServiceBranchData extends \SimpleXmlElement {

	var $nsPrefix = "";

	public function __construct(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		$this->tuneNamespaces();
		return parent::__construct($data, $options, $dataIsURL, $namespaceOrPrefix, $isPrefix);
	}

	function tuneNamespaces() {
		// Prohledani namespacu a prirazeni prefixu tam, kde je prazdny.
		// jinak nelze pouzit volani xpath()

		foreach($this->getDocNamespaces() as $strPrefix => $strNamespace) {
			if (in_array($strPrefix, ["xsi", "xsd"])) {
				continue;
			}
			if(strlen($strPrefix)==0) {
				$this->nsPrefix="default"; //Assign an arbitrary namespace prefix.
			}
			$this->registerXPathNamespace($this->nsPrefix,$strNamespace);
		}

		$this->registerXPathNamespace("br", "http://atk14.org/branch");
	}

	public function getBranchNodes($options=[]) {
		$nsPrefix = isset($this->nsPrefix) ? $this->nsPrefix : "";
		$_branch_element_name = sprintf("//%s%s", ($nsPrefix ? $nsPrefix.":" : ""), $static::GetXMLBranchName());

		return $this->xpath($_branch_element_name);;
	}
}
