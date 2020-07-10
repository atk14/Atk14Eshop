<?php
class DeliveryServiceBranchField extends CharField {
	function __construct($options = array()) {
		$options += array(
			# kvuli naseptavani
			"delivery_service_id" => null,
		);
		$options += array(
			"label" => _("Zadejte název obce nebo PSČ"),
			"widget" => new DeliveryServiceBranchInput(["delivery_service_id" => $options["delivery_service_id"]]),
		);

		$this->options = $options;
		parent::__construct($options);
	}

	function format_initial_data($value) {
		if ($value && is_a($value, "DeliveryServiceBranch")) {
			return $value->getId();
		}
		return $value;
	}

	function clean($value) {
		list($err,$value) = parent::clean($value);
		if ($err) {
			return array($err,$value);
		}

		$branch = null;
		if ($value && is_null($branch = DeliveryServiceBranch::FindById( (int)$value))) {
			return array(_("Pobočka nebyla nalezena"), null);
		}
		return array(null, $branch);
	}
}
