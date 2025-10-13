<?php
class BasketErrorMessage {

	protected $message;

	protected $correction_text;
	protected $correction_url;
	protected $request_method;

	/**
	 *	$message = new BasketErrorMessage("Basket is empty");
	 *
	 *	$message = new BasketErrorMessage("The product XYZ is not awailable",[
	 *		"correction_text" => "Remove from basket",
	 *		"correction_url" => $this->_link_to(...),
	 *		"request_method" => "POST"
	 *	]);
	 */
	function __construct($message,$options = []){
		$options += [
			"correction_text" => "",
			"correction_url" => "",
			"request_method" => "POST", // POST, GET
		];

		$this->message = $message;

		$this->correction_text = $options["correction_text"];
		$this->correction_url = $options["correction_url"];
		$this->request_method = $options["request_method"];
	}

	function getCorrectionText(){
		return $this->correction_text;
	}

	function getCorrectionUrl(){
		return $this->correction_url;
	}

	function getRequestMethod(){
		return $this->request_method;
	}

	function __toString(){
		return (string)$this->message;
	}
}
