<?php
class PaymentStatus extends ApplicationModel {

	use TraitGetInstanceByCode;

	function getName(){
		$code = $this->getCode();
		$tr = [
			"pending" => _("Čeká se na dokončení platby"),
			"paid" => _("Zaplaceno"),
			"cancelled" => _("Zrušeno"),
		];
		return !is_null($tr[$code]) ? $tr[$code] : $code;
	}

	function toString(){
		return (string)$this->getName();
	}
}
