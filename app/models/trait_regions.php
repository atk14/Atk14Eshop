<?php
/**
 * Pro modely (PaymentMethod, DeliveryMethod), ktere maji policko regions, ale nepouzivaji $JsonFields (to pouziva napr. Page)
 */
trait TraitRegions {

	function getRegions(){
		if(!$json = $this->g("regions")){ return []; }
		$json = json_decode($json,true);

		$out = [];
		foreach(Region::GetAllInstances() as $r){
			$c = $r->getCode();
			if(isset($json[$c]) && $json[$c]){ $out[] = $r; }
		}

		return $out;
	}
}
