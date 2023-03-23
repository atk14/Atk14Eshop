<?php
class PaymentGateway extends ApplicationModel {

	use TraitGetInstanceByCode;

	function getPaymentGatewayApi(){
		$class_name = String4::ToObject($this->getCode())->camelize(); // gp_webpay -> GpWebpay
		$class_name  = "PaymentGatewayApi\\$class_name";
		$api = new $class_name;
		return $api;
	}

	function isProperlyConfigured(){
		$api = $this->getPaymentGatewayApi();
		return $api->isProperlyConfigured();
	}
	
	function toString(){
		return (string)$this->getName();
	}
}
