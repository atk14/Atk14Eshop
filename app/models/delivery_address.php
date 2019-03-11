<?php
class DeliveryAddress extends ApplicationModel {

	static function GetMostRecentRecord($user,$region = null){
		if(!$user){ return; }
		$delivery_countries = $region ? $region->getDeliveryCountries() : [];

		$conditions = $bind_ar = [];

		$conditions[] = "user_id=:user";
		$bind_ar[":user"] = $user;

		if($delivery_countries){
			$conditions[] = "address_country IN :delivery_countries";
			$bind_ar[":delivery_countries"] = $delivery_countries;
		}

		return self::FindFirst([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => "COALESCE(last_used_at,created_at) DESC",
		]);
	}

	static function GetInstancesByUserAndRegion($user,$region){
		if(!$user){ return []; }
		$delivery_countries = $region->getDeliveryCountries();

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
		]);
	}

	static function GetOrCreateRecordByOrder($order){
		$user_id = $order->getUserId();
		if(!isset($user_id)){
			return null;
		}

		$delivery_method = $order->getDeliveryMethod();
		# nebudeme ukladat adresu, pokud je zvolena dorucovaci metoda se zvolenou pobockou
		if (!is_null($delivery_method->getDeliveryService())) {
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

			if(strlen($value)==0){
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
			$da = DeliveryAddress::CreateNewRecord($cr_values);
		}

		return $da;
	}

	function getName(){
		return trim($this->getFirstname()." ".$this->getLastname());
	}
}
