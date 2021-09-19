<?php
class Tag extends ApplicationModel implements Translatable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields(){ return ["tag_localized"]; }

	/**
	 * $tag = Tag::GetOrCreateTag("Nikon");
	 */
	static function GetOrCreateTag($tag){
		if(!strlen($tag)){ return null; }

		($out = Tag::FindByTag($tag)) ||
		($out = Tag::CreateNewRecord(array("tag" => $tag)));

		return $out;
	}

	function getTagLocalized($lang = null){
		global $ATK14_GLOBAL;

		if(!$lang){
			$lang = $ATK14_GLOBAL->getLang();
		}

		if(strlen($out = $this->g("tag_localized_$lang"))>0){
			return $out;
		}

		return $this->getTag();
	}

	function toString(){ return $this->getTag(); }

	function toHumanReadableString(){
		return $this->toString();
	}

	function isDeletable(){
		return
			is_null($this->getCode()) &&
			0==($this->dbmole->selectInt("
				SELECT SUM(cnt) FROM (
					SELECT COUNT(*) AS cnt FROM article_tags WHERE tag_id=:id UNION
					SELECT COUNT(*) AS cnt FROM card_tags WHERE tag_id=:id UNION
					SELECT COUNT(*) AS cnt FROM product_tags WHERE tag_id=:id UNION
					SELECT COUNT(*) AS cnt FROM delivery_method_designated_for_tags WHERE tag_id=:id UNION
					SELECT COUNT(*) AS cnt FROM delivery_method_excluded_for_tags WHERE tag_id=:id UNION
					SELECT COUNT(*) AS cnt FROM delivery_methods WHERE required_tag_id=:id UNION
					SELECT COUNT(*) AS cnt FROM campaign_designated_for_tags WHERE tag_id=:id UNION
					SELECT COUNT(*) AS cnt FROM campaign_excluded_for_tags WHERE tag_id=:id UNION
					-- here is a place for other queries
					SELECT 0 AS cnt
				)q
			",array(":id" => $this)));
	}
}
