<?php
class DeliveryAddress extends ApplicationModel {

	/**
	 *
	 *	$da = DeliveryAddress::GetMostRecentRecord($user);
	 *	$da = DeliveryAddress::GetMostRecentRecord($user,["CZ","SK"]);
	 * 	$da = DeliveryAddress::GetMostRecentRecord($user,$region);
	 */
	static function GetMostRecentRecord($user,$delivery_countries = null){
		$instances = self::GetInstancesByUser($user,$delivery_countries);
		if($instances){
			return $instances[0];
		}
	}
	
	/**
	 *
	 *	$da = DeliveryAddress::GetInstancesByUser($user);
	 *	$da = DeliveryAddress::GetInstancesByUser($user,["CZ","SK"]);
	 *	$da = DeliveryAddress::GetInstancesByUser($user,$region);
	 */
	static function GetInstancesByUser($user,$delivery_countries = null){
		if(!$user){ return []; }
		if(is_object($delivery_countries) && is_a($delivery_countries,"Region")){
			$delivery_countries = $delivery_countries->getDeliveryCountries();
		}

		$conditions = $bind_ar = [];

		$conditions[] = "user_id=:user";
		$bind_ar[":user"] = $user;

		if($delivery_countries){
			$conditions[] = "address_country IN :delivery_countries";
			$bind_ar[":delivery_countries"] = $delivery_countries;
		}

		return self::FindAll([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => "COALESCE(last_used_at,created_at) DESC",
		],[
			"use_cache" => true,
		]);
	}

	static function GetOrCreateRecordByOrder($order){
		$user_id = $order->getUserId();
		if(!isset($user_id)){
			return null;
		}

		$delivery_method = $order->getDeliveryMethod();
		# nebudeme ukladat adresu, pokud je zvolena dorucovaci metoda se zvolenou pobockou
		if(!is_null($delivery_method->getDeliveryService())){
			return null;
		}
		if(!is_null($delivery_method->getPersonalPickupOnStore())){
			return null;
		}
		$conditions = $bind_ar = [];

		$conditions[] = "user_id=:user_id";
		$bind_ar[":user_id"] = $user_id;

		$cr_values = [];
		$cr_values["user_id"] = $order->getUserId();

		foreach([
			"firstname",
			"lastname",
			"company",
			"address_street",
			"address_street2",
			"address_city",
			"address_zip",
			"address_country",
			"address_note",
			"phone",
		] as $key){
			$o_key = "delivery_$key";
			//$o_method = String4::ToObject($o_key)->camelize()->prepend("get")->toString(); // delivery_street -> getDeliveryStreet()
			//$value = $order->$o_method();
			$value = $order->g("$o_key");

			$cr_values[$key] = $value;

			if(strlen((string)$value)==0){
				$conditions[] = "$key='' OR $key IS NULL";
			}else{
				$conditions[] = "$key=:$key";
				$bind_ar[":$key"] = $value;
			}
		}

		//var_dump($conditions);
		//var_dump($bind_ar);
		//exit;

		$da = DeliveryAddress::FindFirst([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
		]);
		
		if(!$da){
			$cr_values["created_automatically"] = true;
			$da = DeliveryAddress::CreateNewRecord($cr_values);
		}

		return $da;
	}

	function getName(){
		return trim($this->getFirstname()." ".$this->getLastname());
	}

	function toExportArray(){
		$out = $this->toArray();
		foreach(["user_id","last_used_at","created_at","updated_at","created_automatically"] as $k){
			unset($out[$k]);
		}
		Atk14Require::Helper("modifier.display_phone");
		$phone = $out["phone"];
		$phone = smarty_modifier_display_phone($phone,false);
		$phone = str_replace(html_entity_decode("&nbsp;")," ",$phone);
		$out["phone"] = $phone;
		return $out;
	}
}
