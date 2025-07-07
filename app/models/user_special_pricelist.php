<?php
class UserSpecialPricelist extends ApplicationModel implements Rankable {

	function setRank($rank){
		return $this->_setRank($rank,[
			"user_id" => $this->g("user_id"),
		]);
	}

	function getSpecialPricelist(){
		return Cache::Get("SpecialPricelist",$this->g("special_pricelist_id"));
	}
}
