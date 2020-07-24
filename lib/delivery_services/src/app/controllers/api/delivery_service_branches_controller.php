<?php
class DeliveryServiceBranchesController extends ApiController {

	/**
	 * ### Seznam pošt
	 */
	function index() {
		if(!$this->params->isEmpty() && ($d = $this->form->validate($this->params))){
			$this->api_data = array();
			if (is_null($delivery_service = DeliveryService::FindById($this->params->getInt("delivery_service_id")))) {
				return $this->_report_fail(_("Bad request"),400);
			}

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

	/**
	 * ### Detail pošty
	 */
	function detail() {
		if(!$this->params->isEmpty() && ($d = $this->form->validate($this->params))){
			if (!$office = PostOffice::FindByZip($d["zip"])) {
				return $this->_execute_action("error404");

			}
			$this->api_data = ObjectDump::Dump($office);
		}

	}

	function _private_ip_required(){ return true; }
}
