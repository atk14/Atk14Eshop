<?php
class DeliveryServiceBranch extends ApplicationModel {

	function getDeliveryMethodData() {
		$_service = $this->getDeliveryService();
		return json_encode([
			"external_branch_id" => $this->getExternalBranchId(),
			"delivery_service_id" => $_service->getId(),
			"delivery_service_code" => $_service->getCode(),
			"delivery_address" => [
				"company" => $_service->getName(),
				"place" => $this->getPlace(),
				"street" => $this->getStreet(),
				"city" => $this->getCity(),
				"zip" => $this->getZip(),
				"country" => $this->getCountry(),
			],
		]);
	}
}
