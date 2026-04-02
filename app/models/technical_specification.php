<?php
class TechnicalSpecification extends ApplicationModel implements Translatable, Rankable, \Textmit\Indexable {

	public static function GetTranslatableFields(){ return array("content_localized"); }

	public static function CreateNewRecord($values,$options = array()){
		$values += array(
			"content" => null,
		);

		$key = Cache::Get("TechnicalSpecificationKey",$values["technical_specification_key_id"]);

		if(!array_key_exists("content_json",$values) && $key){
			$type = $key->getType();
			$transformator = $type->getTransformator();
			if($transformator){
				$raw_conent = $transformator->parseValue((string)$values["content"]);
				if(!is_null($raw_conent)){
					$values["content_json"] = $transformator->encodeValue($raw_conent);
					if(!$transformator->shouldBeContentValuePreserved((string)$values["content"])){
						$values["content"] = null;
					}
				}
			}
		}

		if(self::$TechnicalSpecificationCache){
			self::$TechnicalSpecificationCache->flushCache();
		}

		return parent::CreateNewRecord($values,$options);
	}

	/**
	 * Saves a technical specification for the given product card
	 *
	 *	$ts = TechnicalSpecification::CreateForCard($card,"width","12.3 in");
	 *	$ts = TechnicalSpecification::CreateForCard($card,"width",array("content" => "12.3 in", "content_localized_cs" => "17cm");
	 */
	public static function CreateForCard($card,$key,$values){
		if(!is_a($key,"TechnicalSpecificationKey")){
			$key = TechnicalSpecificationKey::GetOrCreateKey($key);
		}
		if(!is_array($values)){
			$values = array("content" => $values);
		}
		$values["card_id"] = $card;
		$values["technical_specification_key_id"] = $key;
		return TechnicalSpecification::CreateNewRecord($values);
	}

	static $TechnicalSpecificationCache;
	static function GetInstancesForCard($card) {
		if(!self::$TechnicalSpecificationCache){
			self::$TechnicalSpecificationCache = new CacheSomething(
				function($ids) {
					$ids += Cache::CachedIds("Card");
					$dbmole = Article::GetDbmole();
					$rows = $dbmole->selectRows(
						"
							SELECT
								card_id, id
							FROM
								technical_specifications WHERE card_id IN :ids
							ORDER BY rank, id
						",
						[":ids" => $ids]
					);
					Cache::Prepare("TechnicalSpecification", array_column($rows, "id"));
					$out = array_fill_keys($ids, []);
					foreach($rows as $row){
						$card_id = $row["card_id"];
						$out[$card_id][] = Cache::Get("TechnicalSpecification",$row["id"]);
					}
					return $out;
				},
				"TechnicalSpecification"
			);
		}

		return self::$TechnicalSpecificationCache->get($card);
	}

	static function GetForCard($card, $key) {
		if(!is_a($key,"TechnicalSpecificationKey")){
			$key = TechnicalSpecificationKey::GetInstanceByKey($key);
		}
		if(!$key){ return null; }

		foreach(self::GetInstancesForCard($card) as $technical_specification){
			if($technical_specification->getTechnicalSpecificationKeyId()===$key->getId()){ return $technical_specification; }
		}
		return null;
	}

	function setRank($rank){
		return $this->_setRank($rank,array("card_id" => $this->g("card_id")));
	}

	function getTechnicalSpecificationKey(){
		return Cache::Get("TechnicalSpecificationKey",$this->getTechnicalSpecificationKeyId());
	}

	function getKey(){
		return $this->getTechnicalSpecificationKey();
	}

	/**
	 *
	 * @return string
	 */
	function getContent($lang = null){
		global $ATK14_GLOBAL;

		if(is_null($lang)){
			$lang = $ATK14_GLOBAL->getLang();
		}

		if(strlen($content = (string)$this->g("content_localized_$lang"))){
			return $content;
		}

		if(strlen($content = (string)$this->g("content"))){
			return $content;
		}
	
		if(($json = $this->g("content_json")) && ($transformator = $this->getKey()->getType()->getTransformator())){
			return $transformator->decodeValueAsString($json);
		}
	}

	/**
	 *
	 * @return mixed
	 */
	function getRawContent($lang = null){
		global $ATK14_GLOBAL;
		if(is_null($lang)){
			$lang = $ATK14_GLOBAL->getLang();
		}

		if(($json = $this->g("content_json")) && ($transformator = $this->getKey()->getType()->getTransformator())){
			return $transformator->decodeValue($json);
		}

		if(strlen($content = (string)$this->g("content_localized_$lang"))){
			return $content;
		}

		if(strlen($content = (string)$this->g("content"))){
			return $content;
		}
	}

	function toString(){
		return (string)$this->getContent();
	}

	function isIndexable(){
		return true;
	}

	function getFulltextData($lang){
		Atk14Require::Helper("modifier.markdown");

		$fd = new \Textmit\FulltextData($this,$lang);

		$key = $this->getKey();

		$fd->addText($key->getKey($lang),"d");
		$fd->addText($this->getContent($lang));

		return $fd;
	}
}
