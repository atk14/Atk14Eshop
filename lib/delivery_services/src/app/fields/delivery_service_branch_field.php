<?php
class DeliveryServiceBranchField extends CharField {

	var $delivery_service;

	function __construct(DeliveryService $delivery_service, $options = []) {
		$options += [
			"label" => _("Zadejte název obce nebo PSČ"),
		];
		$this->delivery_service = $delivery_service;
		parent::__construct($options);
	}

	function format_initial_data($value) {
		if (is_numeric($value)) {
			if ($_branch = DeliveryServiceBranch::GetInstanceById($value)) {
				$value = $_branch;
			}
		}
		if ($value && is_a($value, "DeliveryServiceBranch")) {
			return $value->getExternalBranchId();
		}
		return $value;
	}

	function clean($value) {
		list($err,$value) = parent::clean($value);
		if ($err) {
			return [$err,$value];
		}

		$branch = null;
		if ($value && is_null($branch = DeliveryServiceBranch::FindFirst( "delivery_service_id", $this->delivery_service, "external_branch_id", $value))) {
			return [_("Výdejní místo nebylo nalezeno"), null];
		}
		return [null, $branch];
	}
}
