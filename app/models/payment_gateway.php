<?php
class PaymentGateway extends ApplicationModel {

	use TraitGetInstanceByCode;

	function isProperlyConfigured(){
		$class_name = String4::ToObject($this->getCode())->camelize(); // gp_webpay -> GpWebpay
		$class_name  = "PaymentGatewayApi\\$class_name";

		return $class_name::IsProperlyConfigured();
	}
	
	function toString(){
		return (string)$this->getName();
	}
}
