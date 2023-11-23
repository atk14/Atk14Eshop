<?php

namespace DeliveryService\BranchParser;

class DeliveryServiceBranchData extends \SimpleXmlElement {

	var $nsPrefix = "";

	/**
	 * @note can not be used in PHP version < 8
	 */
	/*
	public function __construct(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		parent::__construct($data, $options, $dataIsURL, $namespaceOrPrefix, $isPrefix);
		$this->tuneNamespaces();
	}
	 */

	public static function GetInstance(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		$instance = new static($data, $options, $dataIsURL, $namespaceOrPrefix, $isPrefix);
		$instance->tuneNamespaces();
		return $instance;
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

	public function _getBranchNodes($options=[]) {
		$nsPrefix = isset($this->nsPrefix) ? $this->nsPrefix : "";
		$_branch_element_name = sprintf("//%s%s", ($nsPrefix ? $nsPrefix.":" : ""), static::GetXMLBranchName());

		return $this->xpath($_branch_element_name);;
	}

	function toArray() {
		return [
			"external_branch_id" => $this->getExternalBranchId(),
			"name" => $this->getBranchName(),
			"place" => $this->getPlaceName(),

			"full_address" => $this->getFullAddress(),
			"country" => $this->getCountryCode(),
			"district" => $this->getDistrict(),
			"zip" => $this->getZipCode(),
			"city" => $this->getCity(),
			"street" => $this->getStreet(),

			"url" => $this->getInformationUrl(),
			"opening_hours" => json_encode($this->getOpeningHours()),
			"location_latitude" => $this->getLatitude(),
			"location_longitude" => $this->getLongitude(),
			"active" => $this->isActive(),
		];
	}
}
