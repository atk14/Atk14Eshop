<?php

namespace DeliveryService\BranchParser;

class SimpleStdClassElement extends \StdClass {
	public function __construct(
		$data,
		int $options = 0
	) {
		$this->_data = $data;
	}
}
class DeliveryServiceBranchStdClassData extends SimpleStdClassElement {

	public static function GetInstance(
		$data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		$instance = new static($data, $options, $dataIsURL, $namespaceOrPrefix, $isPrefix);
		$instance->_data = $data;
		return $instance;
	}

	public function _getBranchNodes($options=[]) {
		return array_map(function($e) {
			return new static($e);
		}, $this->_data);
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

