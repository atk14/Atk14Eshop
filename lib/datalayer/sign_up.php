<?php
class SignUp extends DatalayerGenerator\MessageGenerators\ActionBase implements DatalayerGenerator\MessageGenerators\iMessage {

	function __construct($object, $options=[]) {
		$options += [
			"origin" => "button", # button, checkout
		];
		return parent::__construct($object, $options);
	}

	function getEvent() {
		return "sign_up";
	}

	function getDatalayerMessage() {
		return $this->getActivityData();
	}

	function getActivityData() {
		return [
			"event" => $this->getEvent(),
			"signup" => [
				"origin" => $this->options["origin"],
			],
		];
	}
}
