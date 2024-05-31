<?php
class ProductType extends ApplicationModel implements Translatable, iSlug, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields() { return array("name", "page_title_pattern");}

	function getSlugPattern($lang){
		return $this->g("name_$lang");
	}

	function getSlugSegment(){
		// there must be no uniqueness constraint,
		// so every record has its own segment
		return (string)$this->getId();
	}

	function setRank($rank){
		return $this->_setRank($rank);
	}

	/**
	 *
	 *	echo $product_type->generatePageTitleForProduct($product);
	 *	echo $product_type->generatePageTitleForProduct($card);
	 */
	function generatePageTitleForProduct($product,$lang = null){
		$title = new String4($this->getPageTitlePattern($lang));
		$card = is_a($product,"Card") ? $product : $product->getCard();

		$title = $title->replace("%product_name%",$product->getName($lang));

		if($title->contains("%main_creators%")){
			if($creators = CardCreator::GetMainCreatorsForCard($card)){
				Atk14Require::Helper("modifier.to_sentence");
				$title = $title->replace("%main_creators%",smarty_modifier_to_sentence($creators));
			}else{
				$title = $title->replace("%main_creators%","");
				
				// " - The Book" or "The Book - " -> "The Book"
				$title = $title
					->trim()
					->gsub('/ +-$/','')
					->gsub('/^- +/','');
			}
		}

		if($title->contains("%catalog_id%")){
			$product = $card->getFirstProduct();
			$title = $title->replace("%catalog_id%",$product ? $product->getCatalogId() : "");
		}

		$title = $title->trim();

    return $title->toString();
	}

	function isDeletable(){
		if($this->getId()===1){ return false; }
		return 0 === $this->dbmole->selectInt("SELECT COUNT(*) FROM cards WHERE product_type_id=:product_type",array(":product_type" => $this));
	}

	function toString(){
		return (string)$this->getName();
	}
}
