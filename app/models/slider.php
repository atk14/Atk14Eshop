<?php
class Slider extends ApplicationModel {

	function getItems(){
		return SliderItem::FindAll("slider_id",$this);
	}
}
