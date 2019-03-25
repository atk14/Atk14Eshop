<?php
class Slider extends ApplicationModel implements Rankable {

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getItems(){
		return SliderItem::FindAll("slider_id",$this);
	}

	function getImageUrl(){
		if($items = $this->getItems()){
			return $items[0]->getImageUrl();
		}
	}

	function isDeletable(){
		return true;
	}
}
