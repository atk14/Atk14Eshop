<?php
class WatchedProduct extends ApplicationModel {

	static function CreateNewRecord($values,$options = []){
		global $ATK14_GLOBAL;

		$values += [
			"language" => $ATK14_GLOBAL->getLang(),
		];

		return parent::CreateNewRecord($values,$options);
	}

	static function IsWatchedProduct($product,$user){
		if(is_null($user)){
			return null;
		}
		return self::FindFirst("product_id",$product,"user_id",$user,"notified",false);
	}

	static function GetWatchedProductsToNotify(){
		$conditions = [
			"watched_products.notified='f'",
			"COALESCE((SELECT SUM(stockcount) FROM warehouse_items WHERE product_id=watched_products.product_id AND warehouse_id IN (SELECT id FROM warehouses WHERE applicable_to_eshop)),0)-(COALESCE((SELECT SUM(stockcount) FROM v_stockcount_blocations WHERE product_id=watched_products.product_id),0))>0",
		];

		return self::FindAll([
			"conditions" => $conditions,
		]);
	}

	function getUser(){
		return Cache::Get("User",$this->getUserId());
	}

	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
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

	function markAsNotified() {
		$this->setValues([
			"notified" => true,
			"notified_at" => now(),
		]);
	}
}
