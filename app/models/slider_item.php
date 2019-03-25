<?php
class SliderItem extends ApplicationModel implements Translatable, Rankable {

	use TraitUrlParams;

	static function GetTranslatableFields(){ return ["title", "description"]; }

	function setRank($rank){
		$this->_setRank($rank,["slider_id" => $this->getSliderId()]);
	}

	function toString(){ return $this->getImageUrl(); }
}
