<?php
class DeliveryServiceBranchesController extends ApiController {

	/**
	 * ### Seznam pošt
	 */
	function index() {
		if(!$this->params->isEmpty() && ($d = $this->form->validate($this->params))){
			$this->api_data = array();
			if (is_null($delivery_method = DeliveryMethod::FindById($this->params->getInt("delivery_method_id")))) {
				return $this->_report_fail(_("Bad request"),400);
			}
			if (is_null($service = $delivery_method->getDeliveryService())) {
				return $this->_report_fail(_("Bad request"),400);
			}

			foreach($service->findBranches($d["q"], array("countries" => $this->current_region->getDeliveryCountries())) as $_office) {
				$obj_dump = $_office->toArray();
				# label pro naseptavadlo, ktery chceme vzdy ve stejnem formatu a udaje chceme mit v urcitem poradi
				$ar = [
					"value" => $obj_dump["id"],
					"label" => sprintf("%s, %s - %s", $obj_dump["zip"], $obj_dump["full_address"], $obj_dump["place"]),
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
