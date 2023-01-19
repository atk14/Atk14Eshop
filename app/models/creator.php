<?php
class Creator extends ApplicationModel implements Translatable {

	static function GetTranslatableFields(){ return ["name_localized"]; } // good for e.g. "team of authors" in english, "kolektiv autoru" in czech

	static function GetInstanceByName($name){
		$name = trim($name);
		return self::FindFirst([
			"conditions" => [
				"LOWER(name)=LOWER(:name)"
			],
			"bind_ar" => [
				":name" => $name,
			]
		]);
	}

	/**
	 *
	 *	$creator->getName();
	 *	$creator->getName("en");
	 *	$creator->getName(false);
	 */
	function getName($return_name_localized = true,$lang = null){
		global $ATK14_GLOBAL;

		if(is_string($return_name_localized) && is_null($lang)){
			$lang = $return_name_localized;
			$return_name_localized = true;
		}

		if(!$return_name_localized){
			return $this->g("name");
		}

		if(is_null($lang)){
			$lang = $ATK14_GLOBAL->getLang();
		}

		if(strlen($name = (string)$this->g("name_localized_$lang"))){
			return $name;
		}

		return $this->g("name");
	}

	function getPage(){
		return Cache::Get("Page",$this->getPageId());
	}

	function getImageUrl(){
		if($url = $this->g("image_url")){
			return $url;
		}
		
		if($page = $this->getPage()){
			return $page->getImageUrl();
		}
	}

	function getRoles(){
		$ids = $this->dbmole->selectIntoArray("
			SELECT DISTINCT id FROM (
			SELECT
				creator_roles.id
			FROM
				card_creators,
				creator_roles,
				cards
			WHERE
				card_creators.creator_id=:creator AND
				creator_roles.id=card_creators.creator_role_id AND
				cards.id=card_creators.card_id AND
				cards.visible AND
				NOT cards.deleted
			ORDER BY
				creator_roles.rank,
				creator_roles.id,	
				cards.created_at DESC
			)q
		",[":creator" => $this]);
		return Cache::Get("CreatorRole",$ids);
	}

	/**
	 *
	 *	$cards = $creator->getCards(["limit" => 5]);
	 *	$cards = $creator->getCards($role_author,["limit" => 5]);
	 */
	function getCards($role = null,$options = []){
		if(is_array($role)){
			$options = $role;
			$role = null;
		}
		$options += [
			"limit" => null,
		];

		$bind_ar = [":creator" => $this];
		$sql_cond_role = "";
		if($role){ 
			$sql_cond_role = "creator_roles.id=:creator_role AND";
			$bind_ar[":creator_role"] = $role;
		}
		$ids = $this->dbmole->selectIntoArray("
			SELECT
				cards.id
			FROM
				card_creators,
				creator_roles,
				cards
			WHERE
				card_creators.creator_id=:creator AND
				creator_roles.id=card_creators.creator_role_id AND
				$sql_cond_role
				cards.id=card_creators.card_id AND
				cards.visible AND
				NOT cards.deleted
			ORDER BY
				creator_roles.rank,
				creator_roles.id,	
				cards.created_at DESC
		",$bind_ar,$options);
		return Cache::Get("Card",$ids);
	}

	function toHumanReadableString(){
		return $this->g("name");
	}

	function toString(){
		return (string)$this->getName();
	}
}
