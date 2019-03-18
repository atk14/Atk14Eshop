<?php
class PaymentGateway extends ApplicationModel {
	
	function toString(){
		return (string)$this->getName();
	}
}
