<?php
class CardCreator extends ApplicationModel implements Rankable {

	static function GetCreatorsForCard($card){
		return self::FindAll("card_id",$card);
	}

	static function GetMainCreatorsForCard($card){
		return self::FindAll("card_id",$card,"is_main_creator",true);
	}

	function setRank($new_rank){
		$this->_setRank($new_rank,array(
			"card_id" => $this->g("card_id")
		));
	}

	function getCreator(){
		return Cache::Get("Creator",$this->getCreatorId());
	}

	function getCreatorRole(){
		return Cache::Get("CreatorRole",$this->getCreatorRoleId());
	}

	function getName(){
		return $this->getCreator()->getName();
	}

	function getPage(){
		return $this->getCreator()->getPage();
	}

	function isMainCreator(){ return $this->g("is_main_creator"); }

	function toString(){
		return $this->getCreator()->toString();
	}
}
