<?php

namespace DeliveryService\BranchParser;

class DeliveryServiceJsonBranchData extends SimpleJsonElement {

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
		];
	}
}

