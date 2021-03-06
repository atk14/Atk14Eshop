<?php
class CardSection extends ApplicationModel implements Translatable, Rankable{

	static function GetTranslatableFields(){ return array("name","body"); }

	function getImages(){
		return Image::GetImages($this);
	}

	function getAttachments(){
		return Attachment::GetAttachments($this);
	}

	function getEmbeddedVideos() {
		return EmbeddedVideo::GetEmbeddedVideos($this);
	}

	function getProducts(){
		return Product::FindAll("card_id",$this);
	}

	function setRank($rank){
		return $this->_setRank($rank,array(
			"card_id" => $this->getCardId(),
		));
	}

	/**
	 *
	 *	echo $section->getTypeCode(); // e.g. "information"
	 */
	function getTypeCode(){
		return $this->getCardSectionType()->getCode();
	}

	function getFulltextData($lang){
		Atk14Require::Helper("modifier.markdown");

		$fd = new \Textmit\FulltextData($this,$lang);

		$fd->addText($this->getName($lang),"a");

		$fd->addHtml(smarty_modifier_markdown($this->getBody($lang)));

		return $fd;
	}
}
