<?php
class FavouriteProduct extends ApplicationModel implements Rankable {

	function setRank($rank){
		return $this->_setRank($rank,[
			"user_id" => $this->g("user_id"),
			"session_token" => $this->g("session_token"),
		]);
	}

	function getProduct(){
		return Cache::Get("Product",$this->getProductId());
	}
}
