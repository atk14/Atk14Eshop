<?php
class OrderLabel extends ApplicationModel implements Translatable, Rankable {

	function GetTranslatableFields(){ return ["title"]; }

	function setRank($rank){ return $this->_setRank($rank); }

	function isDeletable(){
		return 0===$this->dbmole->selectInt("
			SELECT COUNT(*) FROM (
				(SELECT id FROM orders WHERE order_color_id=:order_color LIMIT 1)
			)q
		",[":order_color" => $this]);
	
}
