<?php
class ShippingCombination extends ApplicationModel {

	static function SetPaymentMethodsForDeliveryMethod($delivery_method, $payment_methods) {
		$dbmole = self::GetDbMole();

		$dbmole->doQuery("DELETE FROM shipping_combinations WHERE delivery_method_id=:delivery_method_id", array(":delivery_method_id" => $delivery_method));
		if(!$payment_methods){ return; }
		$dbmole->doQuery("INSERT INTO shipping_combinations (delivery_method_id, payment_method_id) SELECT :delivery_method_id,id FROM payment_methods WHERE id IN :payment_method_ids", array(
			":delivery_method_id" => $delivery_method,
			":payment_method_ids" => $payment_methods,
		));
	}

	static function GetPaymentMethodIdsForDeliveryMethod($delivery_method) {
		$dbmole = self::GetDbMole();
		return $dbmole->selectIntoArray("
			SELECT
				shipping_combinations.payment_method_id
			FROM
				shipping_combinations,
				payment_methods
			WHERE
				shipping_combinations.delivery_method_id=:delivery_method_id AND
				payment_methods.id=shipping_combinations.payment_method_id
			ORDER BY
				payment_methods.rank,
				payment_methods.id	
		", array(":delivery_method_id" => $delivery_method));
	}

	static function GetPaymentMethodsForDeliveryMethod($delivery_method) {
		$payment_ids = self::GetPaymentMethodIdsForDeliveryMethod($delivery_method);
		return Cache::Get("PaymentMethod",$payment_ids);
	}

	static function SetDeliveryMethodsForPaymentMethod($payment_method, $delivery_methods) {
		$dbmole = self::GetDbMole();

		$dbmole->doQuery("DELETE FROM shipping_combinations WHERE payment_method_id=:payment_method_id", array(":payment_method_id" => $payment_method));
		if(!$delivery_methods){ return; }
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
		if(is_null($delivery_method_id) || is_null($payment_method_id)){
			return null;
		}

		!is_object($delivery_method_id) && ($delivery_method_id = DeliveryMethod::GetInstanceById($delivery_method_id));
		# check if DeliveryMethod is connected to a DeliveryService and if it is usable in that case.
		if (($delivery_service=$delivery_method_id->getDeliveryService()) && !$delivery_service->canBeUsed()) {
			return false;
		}

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

	/**
	 * Pro nakupni kosik vybere vsechny myslitelne zpusoby dopravy a platby
	 *
	 * Jejich vzajemne kombinace se samozrejme dale rozhoduje podle zaznamu v shipping_combinations.
	 *
	 *	list($delivery_methods,$payment_methods) = ShippingCombination::GetAllowedMethods4Basket($basket);
	 *	list($delivery_methods,$payment_methods) = ShippingCombination::GetAllowedMethods4Basket($basket,["cash_on_delivery_enabled" => false]);
	 */
	static function GetAvailableMethods4Basket($basket,$options = []){
		$options += [
			"online_payment_methods_required" => $basket->onlinePaymentMethodRequired(),
			"cash_on_delivery_enabled" => $basket->cashOnDeliveryEnabled(),
		];

		$region = $basket->getRegion();
		($user = $basket->getUser()) || ($user = User::GetAnonymousUser());

		$conditions = $bind_ar = [];
		$conditions[] = "active";

		if($region){
			$conditions[] = "(regions->>:region)::BOOLEAN";
			$bind_ar[":region"] = $region->getCode();
		}

		if($options["online_payment_methods_required"]){
			$conditions[] = "id IN (SELECT delivery_method_id FROM shipping_combinations WHERE payment_method_id IN (SELECT id FROM payment_methods WHERE payment_gateway_id IS NOT NULL".($region ? " AND (regions->>:region)::BOOLEAN" : "")."))";
		}

		if(!$options["cash_on_delivery_enabled"]){
			$conditions[] = "id IN (SELECT delivery_method_id FROM shipping_combinations WHERE payment_method_id IN (SELECT id FROM payment_methods WHERE NOT cash_on_delivery".($region ? " AND (regions->>:region)::BOOLEAN" : "")."))";
		}

		// Tady se mozna prida i tag "envelope_delivery"
		$_tags = [];
		foreach(["digital_product"] as $_code){
			$_tag = Tag::GetInstanceByCode($_code);
			if(!$_tag){ continue; }
			if($basket->hasEveryProductTag($_tag)){
				$_tags[] = $_tag;
			}
		}
		if($_tags){
			$conditions[] = "required_tag_id IN :required_tags";
			$bind_ar[":required_tags"] = $_tags;
		}

		$delivery_methods = [];
		$exclusive_delivery_methods = [];
		foreach(DeliveryMethod::FindAll([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
		]) as $o){
			if(!is_null($o->g("required_customer_group_id")) && !$user->isInCustomerGroup($o->g("required_customer_group_id"))){
				continue;
			}

			# kontrola, ze dorucovaci sluzba pouzita pro tuto metodu muze byt pouzita
			# napriklad je zadany api klic (zatim jen toto)
			if (($ds = $o->getDeliveryService()) && !$ds->canBeUsed()) {
				continue;
			}

			foreach($o->getDesignatedForTags() as $t){
				if(!$basket->containsProductWithTag($t)){
					continue 2;
				}
			}

			foreach($o->getExcludedForTags() as $t){
				if($basket->containsProductWithTag($t)){
					continue 2;
				}
			}

			if($tag_required = $o->getRequiredTag()){
				if(!$basket->hasEveryProductTag($tag_required)){
					continue;
				}
				$exclusive_delivery_methods[] = $o;
			}
			$delivery_methods[] = $o;
		}

		if($exclusive_delivery_methods){
			$delivery_methods = $exclusive_delivery_methods;
		}

		if(!$delivery_methods){
			return [[],[]];
		}

		//

		$conditions = $bind_ar = [];

		$conditions[] = "active";

		$conditions[] = "(regions->>:region)::BOOLEAN";
		$bind_ar[":region"] = $region->getCode();

		if($options["online_payment_methods_required"]){
			// za online platbu se povazuje i bankovni prevod;
			// ASI-SK-PL-BU je kod u bankovniho prevodu na Slovensku
			//$conditions[] = "payment_gateway_id IS NOT NULL OR code IN ('cs_banktransfer','eu_banktransfer','ASI-SK-PL-BU')";

			// 2019-09-11 - toto prestava platit - za online platebni metodu povazujeme platbu pres platebni branu (je to v souladu s tim, co je vyse)
			$conditions[] = "payment_gateway_id IS NOT NULL";
		}

		if(!$options["cash_on_delivery_enabled"]){
			$conditions[] = "NOT cash_on_delivery";
		}

		$conditions[] = "id IN (SELECT payment_method_id FROM shipping_combinations WHERE delivery_method_id IN :delivery_methods)";
		$bind_ar[":delivery_methods"] = $delivery_methods;

		$payment_methods = [];
		foreach(PaymentMethod::FindAll(["conditions" => $conditions, "bind_ar" => $bind_ar]) as $o){
			if(!is_null($o->g("required_customer_group_id")) && !$user->isInCustomerGroup($o->g("required_customer_group_id"))){
				continue;
			}

			foreach($o->getDesignatedForTags() as $t){
				if(!$basket->containsProductWithTag($t)){
					continue 2;
				}
			}

			foreach($o->getExcludedForTags() as $t){
				if($basket->containsProductWithTag($t)){
					continue 2;
				}
			}

			$payment_methods[] = $o;
		}

		if(!$payment_methods){
			return [[],[]];
		}

		$delivery_methods = DeliveryMethod::FindAll([
			"conditions" => [
				"id IN :delivery_methods",
				"id IN (SELECT delivery_method_id FROM shipping_combinations WHERE payment_method_id IN :payment_methods)"
			],
			"bind_ar" => [
				":delivery_methods" => $delivery_methods,
				":payment_methods" => $payment_methods,
			]
		]);

		if(!$delivery_methods){
			return [[],[]];
		}

		return [$delivery_methods,$payment_methods];
	}
}
