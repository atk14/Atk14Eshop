<?php
class DeliveryServiceBranch extends ApplicationModel {

	function getDeliveryMethodData($encode_to_json = true) {
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
		if($encode_to_json){
			return json_encode($data);
		}
		return $data;
	}
}
