<?php
class DeliveryServiceBranch extends ApplicationModel {

	function getDeliveryMethodData() {
		return json_encode([
			"external_branch_id" => $this->getExternalBranchId(),
			"delivery_address" => [
				"company" => $this->getDeliveryService()->getName(),
				"street" => $this->getStreet(),
				"city" => $this->getCity(),
				"zip" => $this->getZip(),
				"country" => $this->getCountry(),
			],
		]);
	}
}
