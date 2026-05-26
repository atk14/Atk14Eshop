<?php

namespace DeliveryService\BranchParser;

class DeliveryServiceJsonBranchData extends SimpleJsonElement {

	public static function GetInstance(
		string $data,
		int $options = 0,
		bool $dataIsURL = false,
		string $namespaceOrPrefix = "",
		bool $isPrefix = false
	) {
		$instance = new static($data, $options, $dataIsURL, $namespaceOrPrefix, $isPrefix);
		return $instance;
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

	/**
	 * Nektere sluzby mohou mit vydejni mista rozdelena do vice feedu.
	 * Napriklad Zasilkovna ve verzi 5.
	 * Feedy musi mit stejnou strukturu, potom je mozne je spojit.
	 *
	 */
	static function FetchFeed($feed_url) {
		if (!is_array($feed_url)) {
			$feed_url = [$feed_url];
		}
		$data = [];
		foreach($feed_url as $_feed) {
			$_d = @file_get_contents($_feed);
			myAssert($_d!==false);
			$data[] = json_decode($_d, true);
		}
		$data[] = [];
		$data = array_merge((array)$data[0], (array)$data[1]);
		$data = json_encode($data);
		return $data;
	}
}

