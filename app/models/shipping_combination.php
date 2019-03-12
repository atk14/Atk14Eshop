<?php
class ShippingCombination extends ApplicationModel {

	static function SetPaymentMethodsForDeliveryMethod($delivery_method, $payment_methods) {
		$dbmole = self::GetDbMole();

		$dbmole->doQuery("DELETE FROM shipping_combinations WHERE delivery_method_id=:delivery_method_id", array(":delivery_method_id" => $delivery_method));
		$dbmole->doQuery("INSERT INTO shipping_combinations (delivery_method_id, payment_method_id) SELECT :delivery_method_id,id FROM payment_methods WHERE id IN :payment_method_ids", array(
			":delivery_method_id" => $delivery_method,
			":payment_method_ids" => $payment_methods,
		));
	}

	static function GetPaymentMethodIdsForDeliveryMethod($delivery_method) {
		$dbmole = self::GetDbMole();
		return $dbmole->selectIntoArray("SELECT payment_method_id FROM shipping_combinations WHERE delivery_method_id=:delivery_method_id", array(":delivery_method_id" => $delivery_method));
	}

	static function GetPaymentMethodsForDeliveryMethod($delivery_method) {
		$payment_ids = self::GetPaymentMethodIdsForDeliveryMethod($delivery_method);
		return PaymentMethod::GetInstanceById($payment_ids);
	}

	static function SetDeliveryMethodsForPaymentMethod($payment_method, $delivery_methods) {
		$dbmole = self::GetDbMole();

		$dbmole->doQuery("DELETE FROM shipping_combinations WHERE payment_method_id=:payment_method_id", array(":payment_method_id" => $payment_method));
		$dbmole->doQuery("INSERT INTO shipping_combinations (payment_method_id, delivery_method_id) SELECT :payment_method_id,id FROM delivery_methods WHERE id IN :delivery_method_ids", array(
			":payment_method_id" => $payment_method,
			":delivery_method_ids" => $delivery_methods,
		));
	}

	static function GetDeliveryMethodIdsForPaymentMethod($payment_method) {
		$dbmole = self::GetDbMole();
		return $dbmole->selectIntoArray("SELECT delivery_method_id FROM shipping_combinations WHERE payment_method_id=:payment_method_id", array(":payment_method_id" => $payment_method));
	}

	static function GetDeliveryMethodsForPaymentMethod($payment_method) {
		$delivery_ids = self::GetDeliveryMethodIdsForPaymentMethod($payment_method);
		return DeliveryMethod::GetInstanceById($delivery_ids);
	}

	static function GetRules($options=array()) {
		$options += array(
			"format" => "default",
		);

		$dbmole = self::GetDbMole();
		$q = "select delivery_method_id,payment_method_id from shipping_combinations sc, delivery_methods dm,payment_methods pm WHERE sc.delivery_method_id=dm.id AND sc.payment_method_id=pm.id and dm.active and pm.active order by delivery_method_id";
		$rows = $dbmole->selectRows($q);
		$out = [];
		foreach($rows as $r) {
			$dm_id = $r["delivery_method_id"];
			$pm_id = $r["payment_method_id"];
			if (!isset($out[$dm_id])) {
				$out[$dm_id] = array($pm_id);
			} else {
				$out[$dm_id][] = $pm_id;
			}
		}
		if ($options["format"]=="json") {
			return json_encode($out);
		}
		return $out;
	}

	static function IsAllowed($delivery_method_id, $payment_method_id) {
		$dbmole = self::GetDbMole();
		$q = "
			SELECT
				count(*) > 0
			FROM
				shipping_combinations sc, delivery_methods dm,payment_methods pm
			WHERE
				sc.delivery_method_id=dm.id AND
				sc.payment_method_id=pm.id AND
				dm.active AND
				pm.active AND
				delivery_method_id=:delivery_method_id AND
				payment_method_id=:payment_method_id
";
		return $dbmole->selectBool($q, array(":delivery_method_id" => $delivery_method_id, ":payment_method_id" => $payment_method_id));
	}
}
