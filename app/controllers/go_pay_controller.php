<?php
require_once(__DIR__ . "/payment_gateways_base.php");

class GoPayController extends PaymentGatewaysBaseController {

	function finish_transaction(){
		$this->_finish_transaction([
			"parameter_name" => "id"
		]);
	}

}
