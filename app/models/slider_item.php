<?php
class SliderItem extends ApplicationModel implements Translatable, Rankable {

	use TraitUrlParams;

	static function GetTranslatableFields(){ return ["title", "description"]; }

	function setRank($rank){
		$this->_setRank($rank,["slider_id" => $this->getSliderId()]);
	}

	function getSlider(){
		return Cache::Get("Slider",$this->getSliderId());
	}

	function isVisible(){
		if(!$this->g("visible")){ return false; }
		$time = time();
		if(!is_null($this->getDisplayFrom()) && $time<strtotime($this->getDisplayFrom())){ return false; }
		if(!is_null($this->getDisplayTo()) && $time>strtotime($this->getDisplayTo())){ return false; }
		return true;
	}

	function toString(){ return $this->getImageUrl(); }
}
