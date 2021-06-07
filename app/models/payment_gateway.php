<?php
class PaymentGateway extends ApplicationModel {

	use TraitGetInstanceByCode;
	
	function toString(){
		return (string)$this->getName();
	}
}
