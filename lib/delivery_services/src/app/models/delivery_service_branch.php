<?php
class DeliveryServiceBranch extends ApplicationModel {

	function getDeliveryService(){
		return Cache::Get("DeliveryService",$this->getDeliveryServiceId());
	}

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

	function getZip(){
		$zip = $this->g("zip");
		if(in_array($this->getCountry(),["CZ","SK"])){
			$zip = preg_replace('/^(\d{3})(\d{2})$/','\1 \2',$zip);
		}
		return $zip;
	}

	function getAddressStr(){
		return $this->getZip()." ".$this->getCity().", ".$this->getStreet()." - ".$this->getPlace();
	}

	function getDeliveryAddressAr($options = []){
		$out = [
			"delivery_company" => null,
			"delivery_address_street" => null,
			"delivery_address_street2" => null,
			"delivery_address_city" => null,
			"delivery_address_state" => null,
			"delivery_address_zip" => null,
			"delivery_address_country" => null,
			"delivery_address_note" => null,
		];

		$data = $this->getDeliveryMethodData(["as_json" => false]);

		if(!isset($data["delivery_address"])){
			return $out;
		}

		$delivery_address = $data["delivery_address"];
		foreach(["street","city","zip","country"] as $k) {
			$out["delivery_address_${k}"] = $delivery_address[$k];
		}
		//$out["delivery_company"] = $delivery_address["company"] . ($delivery_address["place"] ? " - ".$delivery_address["place"] : "");
		$out["delivery_company"] = $delivery_address["place"];

		return $out;
	}
}
