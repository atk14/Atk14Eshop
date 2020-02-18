<?php
class CardCreator extends ApplicationModel implements Rankable {

	static function GetCreatorsForCard($card){
		return self::FindAll("card_id",$card);
	}

	static $MainCreators;
	static function GetMainCreatorsForCard($card){
		if(!static::$MainCreators) {
			static::$MainCreators = new CacheSomething(function($ids) {
				return
					Cache::Get('CardCreator', self::GetDbMole()->selectIntoAssociativeArray("
					SELECT card_id, id FROM card_creators WHERE card_id IN :ids AND is_main_creator
					", [':ids' => $ids]));
			}, "Card");
		}
		$out = static::$MainCreators->get($card);
		return $out ? [$out]: [];
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

	function getCard(){
		return Cache::Get("Card",$this->getCardId());
	}

	function getRole(){
		return $this->getCreatorRole();
	}

	function getName(){
		return $this->getCreator()->getName();
	}

	function getPage(){
		return $this->getCreator()->getPage();
	}

	function getImageUrl(){
		return $this->getCreator()->getImageUrl();
	}

	function isMainCreator(){ return $this->g("is_main_creator"); }

	function toString(){
		return $this->getCreator()->toString();
	}
}
