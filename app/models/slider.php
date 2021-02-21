<?php
class Slider extends ApplicationModel implements Rankable {

	use TraitGetInstanceByCode;

	function setRank($rank){
		return $this->_setRank($rank);
	}

	function getItems(){
		return SliderItem::FindAll("slider_id",$this);
	}

	function getVisibleItems(){
		$items = $this->getItems();
		$items = array_filter($items,function($item){ return $item->isVisible(); });
		$items = array_values($items);
		return $items;
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
