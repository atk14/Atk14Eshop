<?php
class Store extends ApplicationModel Implements Rankable, Translatable, iSlug, \Textmit\Indexable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return array("name","teaser","description","address","opening_hours"); }

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getSlugPattern($lang){ return $this->g("name_$lang"); }

	function isVisible(){ return $this->getVisible(); }
	
	function isOpen($time = null){
		if(is_null($time)){ $time = time(); }
		if(!is_numeric($time)){ $time = strtotime($time); }

		$date = date("Y-m-d",$time);
		$day = strtolower(date("D",$time)); // "mon" .. "sun"
		$hour = (int)date("G",$time); // 0 .. 23
		$minute = (int)date("i",$time); // 0 .. 59
		$float_time = $hour + $minute/60.0;

		if($special_opening_hour = SpecialOpeningHour::FindFirst("store_id",$this,"date",$date)){
			$opening_hours1 = $special_opening_hour->g("opening_hours1");
			$opening_hours2 = $special_opening_hour->g("opening_hours2");
			$opening_hours3 = $special_opening_hour->g("opening_hours3");
			$opening_hours4 = $special_opening_hour->g("opening_hours4");
		}else{
			$opening_hours1 = $this->g("opening_hours_{$day}1");
			$opening_hours2 = $this->g("opening_hours_{$day}2");
			$opening_hours3 = $this->g("opening_hours_{$day}3");
			$opening_hours4 = $this->g("opening_hours_{$day}4");
		}

		$out = false;

		if(!is_null($opening_hours1)){
			$out = $float_time>=$opening_hours1 && $float_time<=$opening_hours2;
		}

		if($out){ return $out; }

		if(!is_null($opening_hours3)){
			$out = $float_time>=$opening_hours3 && $float_time<=$opening_hours4;
		}

		return $out;
	}

	function isDeletable(){
		return $this->getCode()!="eshop" && !DeliveryMethod::FindFirst("personal_pickup_on_store_id",$this->getId());
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
			"with_name" => false,
			"with_country" => false,
			"connector" => "\n",
		);

		$lang = $options["lang"];

		$address = parent::getAddress($lang);
		if($address){
			return trim($address);
		}

		Atk14Require::Helper("modifier.to_country_name");

		$ary = [
			$this->g("address_street"),
			$this->g("address_street2"),
			$this->g("address_state"),
			$this->g("address_zip")." ".$this->g("address_city"),
		];

		if($options["with_name"]){
			array_unshift($ary,$this->getName());
		}

		if($options["with_country"]){
			$ary[] = smarty_modifier_to_country_name($this->g("address_country"));
		}

		$ary = array_map(function($item){ return trim((string)$item); },$ary);
		$ary = array_filter($ary);
		return join($options["connector"],$ary);
	}

	function getGpsCoordinates(){
		if(is_null($this->g("location_lat")) || is_null($this->g("location_lng"))){
			return;
		}

		$lat = $this->g("location_lat")."N"; // TODO: zaporne je S
		$lng = $this->g("location_lng")."E"; // TODO: zaporne je W
		return "$lat, $lng";
	}

	function toString(){
		return (string)$this->getName();
	}

	function isIndexable(){
		return $this->isVisible();
	}

	function getFulltextData($lang){
		Atk14Require::Helper("modifier.markdown");

		$fd = new \Textmit\FulltextData($this,$lang);

		$fd->addText($this->getName($lang),"a");
		$fd->addText($this->getTeaser($lang),"b");

		$fd->addText($this->getAddress($lang));

		$fd->addHtml(smarty_modifier_markdown($this->getDescription($lang)));

		return $fd;
	}
}
