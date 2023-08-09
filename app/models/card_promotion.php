<?php
class CardPromotion extends Iobject {
	
	function getTitle(){
		$title = parent::getTitle();
		if(strlen((string)$title)){
			return $title;
		}
		$card = $this->getCard();
		return $card->getName();
	}

	function getPreviewImageUrl(){ return $this->getImageUrl(); }

	function getImageUrl(){
		$card = $this->getCard();
		$image = $card->getImage();
		if($image){
			return (string)$image;
		}
	}

	function getCard(){
		return Cache::Get("Card",$this->getCardId());
	}

	function getUrl($options = []){
		$card = $this->getCard();
		return Atk14Url::BuildLink([
			"namespace" => "",
			"controller" => "cards",
			"action" => "detail",
			"id" => $card,
		],$options);
	}
}
