<?php
class DeliveryServiceBranch extends ApplicationModel {

	function getDeliveryMethodData($options = []) {
		if(!is_array($options)){
			$options = ["as_json" => $options];
		}
		$options += [
			"as_json" => true,
		];

		$_service = $this->getDeliveryService();
		$data = [
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
		];

		return $options["as_json"] ? json_encode($data) : $data;
	}
}
