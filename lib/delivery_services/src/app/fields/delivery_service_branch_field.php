<?php
class DeliveryServiceBranchField extends CharField {
	function __construct($options = array()) {
		$options += array(
			# kvuli naseptavani
			"delivery_method_id" => null,
		);
		$options += array(
			"label" => _("Zadejte název obce nebo PSČ"),
			"widget" => new TextInput(array(
				"attrs" => array(
					"data-suggesting" => "yes",
					"data-suggesting_url" => Atk14Url::BuildLink(array(
						"namespace" => "api",
						"controller" => "delivery_service_branches",
						"action" => "index",
						"delivery_method_id" => $options["delivery_method_id"],
						"lang" => "cs",
						"format" => "json",
					))."&q=",
				),
			)),
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
