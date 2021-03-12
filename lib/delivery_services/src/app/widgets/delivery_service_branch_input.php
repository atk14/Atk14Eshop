<?php
class DeliveryServiceBranchInput extends TextInput {

	function __construct($options=[]) {

		$options += [
			"attrs" => [
				"data-suggesting" => "yes",
				"data-suggesting_url" => Atk14Url::BuildLink(array(
					"namespace" => "api",
					"controller" => "delivery_service_branches",
					"action" => "index",
					"delivery_service_id" => $options["delivery_service_id"],
					"lang" => "cs",
					"format" => "json",
				)),
			]
		];
		parent::__construct($options);
	}
}
