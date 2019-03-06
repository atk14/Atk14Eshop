<?php
class Warehouse extends ApplicationModel implements Translatable, Rankable {

	static function GetTranslatableFields(){ return array("name"); }

	function setRank($rank){
		$this->_setRank($rank);
	}
}
