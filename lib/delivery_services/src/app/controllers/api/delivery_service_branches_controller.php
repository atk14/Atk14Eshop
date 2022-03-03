<?php
class DeliveryServiceBranchesController extends ApiController {

	/**
	 * ### List of pickup points for given delivery service
	 */
	function index() {
		if(!$this->params->isEmpty() && ($d = $this->form->validate($this->params))){
			if (is_null($delivery_service = DeliveryService::GetInstanceById($d["delivery_service_id"]))) {
				$this->form->set_error("delivery_service_id",_("Object not found"));
				return;
			}

			$this->api_data = array();
			foreach($delivery_service->findBranches($d["q"], array("countries" => $this->current_region->getDeliveryCountries())) as $_office) {
				$obj_dump = $_office->toArray();
				# label pro naseptavadlo, ktery chceme vzdy ve stejnem formatu a udaje chceme mit v urcitem poradi
				$ar = [
					"value" => $obj_dump["external_branch_id"],
					"label" => sprintf("%s, %s - %s", $obj_dump["zip"], $obj_dump["full_address"], $obj_dump["place"]),
					"opening_hours" => $obj_dump["opening_hours"],
				];
				$this->api_data[] = $ar;
			}
		}
	}
}
