<?php
class WatchedProduct extends ApplicationModel {

	static function IsWatchedProduct($product,$user){
		if(is_null($user)){
			return null;
		}
		return self::FindFirst("product_id",$product,"user_id",$user);
	}

	function getUser(){
		return Cache::Get("User",$this->getUserId());
	}

	function getEmail(){
		if(strlen($this->g("email"))){
			return $this->g("email");
		}
		if($user = $this->getUser()){
			return $user->getEmail();
		}
	}

	function notified(){
		return $this->g("notified");
	}
}
