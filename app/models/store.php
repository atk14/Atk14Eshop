<?php
class Store extends ApplicationModel Implements Rankable, Translatable, iSlug {

	static function GetTranslatableFields(){ return array("name","teaser","description","address","opening_hours"); }

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getSlugPattern($lang){ return $this->g("name_$lang"); }

	function isVisible(){ return $this->getVisible(); }

	function isDeletable(){
		return $this->getCode()!="eshop";
	}

	/**
	 *
	 *	$store->getAddress();
	 *	$store->getAddress("en");
	 *	$store->getAddress([
	 *		"with_country" => true,
	 *	]);
	 */
	function getAddress($lang = null, $options = array()){
		if(is_array($lang)){
			$options = $lang;
			$lang = null;
		}

		$options += array(
			"lang" => $lang,
			"with_country" => false,
		);

		$lang = $options["lang"];

		$address = parent::getAddress($lang);
		if($address){
			return $address;
		}

		Atk14Require::Helper("modifier.to_country_name");

		$ary = [
			$this->g("address_street"),
			$this->g("address_street2"),
			$this->g("address_state"),
			$this->g("address_zip")." ".$this->g("address_city"),
		];

		if($options["with_country"]){
			$ary[] = smarty_modifier_to_country_name($this->g("address_country"));
		}

		$ary = array_map(function($item){ return trim($item); },$ary);
		$ary = array_filter($ary);
		return join("\n",$ary);
	}

	function getGpsCoordinates(){
		if(is_null($this->g("location_lat")) || is_null($this->g("location_lng"))){
			return;
		}

		$lat = $this->g("location_lat")."N"; // TODO: zaporne je S
		$lng = $this->g("location_lng")."E"; // TODO: zaporne je W
		return "$lat, $lng";
	}
}
