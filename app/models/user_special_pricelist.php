<?php
class UserSpecialPricelist extends ApplicationModel implements Rankable {

	function setRank($rank){
		return $this->_setRank($rank,[
			"user_id" => $this->g("user_id"),
		]);
	}

	function getPricelist(){
		return Cache::Get("Pricelist",$this->g("pricelist_id"));
	}
}
