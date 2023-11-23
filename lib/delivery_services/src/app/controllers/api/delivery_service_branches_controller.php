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

			$kh = new \Yarri\KeywordsHighlighter([
				"opening_tag" => "<mark>",
				"closing_tag" => "</mark>",
			]);

			$this->api_data = array();
			foreach($delivery_service->findBranches($d["q"], array("countries" => $this->current_region->getDeliveryCountries())) as $_office) {
				$obj_dump = $_office->toArray();
				$label = $_office->getAddressStr();
				$label = $kh->highlight($label,$d["q"]);
				$ar = [
					"value" => $obj_dump["external_branch_id"],
					"label" => $label,
					"opening_hours" => $obj_dump["opening_hours"],
				];
				$this->api_data[] = $ar;
			}
		}
	}
}
