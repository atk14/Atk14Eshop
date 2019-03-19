<?php
/**
 * Pro modely (PaymentMethod, DeliveryMethod), ktere maji policko regions, ale nepouzivaji $JsonFields (to pouziva napr. Page)
 */
trait TraitRegions {

	function getRegions(){
		if(!$json = $this->g("regions")){ return []; }
		$json = json_decode($json,true);

		$out = [];
		foreach(Region::GetInstances() as $r){
			$c = $r->getCode();
			if($json[$c]){ $out[] = $r; }
		}

		return $out;
	}
}
