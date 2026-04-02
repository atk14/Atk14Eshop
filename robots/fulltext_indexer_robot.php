<?php
class FulltextIndexerRobot extends ApplicationRobot {

	function run(){
		$this->textmit = new \Textmit\Client();
		$adf = $this->textmit->getApiDataFetcher();
		$adf->setSocketTimeout(30.0);

		$this->now = $now = date("Y-m-d H:i:s");

		$this->logger->info("using stage: ".$this->textmit->getStage());
		$this->logger->flush();

		$RECIPE_ITEMS = [
			"Card" => ["conditions" => ["visible","NOT deleted"], "order_by" => "created_at DESC, id DESC"],
			"Page" => ["conditions" => ["visible","indexable","code IS NULL OR code!='homepage'"]],
			"Article" => ["conditions" => ["published_at<=:now"], "bind_ar" => [":now" => $now], "order_by" => "published_at DESC, id DESC"],
			/*
			"Category" => [
				"conditions" => [
					"visible",
					"NOT is_filter",
					"pointing_to_category_id IS NULL",
					"parent_category_id IS NOT NULL",
					"(SELECT COUNT(*) FROM categories p WHERE p.id=parent_category_id AND (p.is_filter OR NOT p.visible))=0"
				]
			], // */
			"Store" => ["conditions" => "visible", "order_by" => "created_at DESC, id DESC"],
		];

		foreach($RECIPE_ITEMS as $class => $options){
			foreach($class::FindAll($options) as $object){
				$this->_indexObject($object);
			}
		}


		// Categories need special care. There are following requirements:
		//
		// - Indexed category must contain at least one product (i.e. card)
		// - Indexed category must be visible including all its parents (Category::isVisible())
		// - Indexed category must not be a flter
		$ids = $this->dbmole->selectIntoArray("
			SELECT
				DISTINCT c.id
			FROM
				cards,
				v_card_categories,
				categories c
			WHERE
				cards.visible AND
				NOT cards.deleted AND
				v_card_categories.card_id=cards.id AND
				c.id=v_card_categories.category_id AND
				c.visible AND
				NOT c.is_filter AND
				(
					c.parent_category_id IS NULL OR
					c.parent_category_id NOT IN (SELECT id FROM categories WHERE is_filter)
				)
			ORDER BY id DESC
		");
		$categories_to_index = [];
		foreach(Cache::Get("Category",$ids) as $category){
			if(!$category->isVisible()){ continue; }
			$parent = $category->getParentCategory();
			if($parent && $parent->isFilter()){ continue; } // Category is a filter option
			if(in_array($category->getId(),$categories_to_index)){ continue; }
			$categories_to_index[] = $category->getId();
			while($parent){
				if(in_array($parent->getId(),$categories_to_index)){ break; }
				$categories_to_index[] = $parent->getId();
				$parent = $parent->getParentCategory();
			}
		}
		foreach(Cache::Get("Category",$categories_to_index) as $category){
			$this->_indexObject($category);
		}

		$deleted = $this->textmit->removeObsoleteDocuments(date("Y-m-d H:i:s",time() - 60 * 60 * 12)); // 12 hours
		$this->logger->info("obsolete documents deleted: $deleted");
	}

	function _indexObject($object){
		global $ATK14_GLOBAL;
		static $counter = 0;

		$counter++;

		if($counter % 1000){
			Cache::Clear();
		}

		$obj_str = get_class($object)."#".$object->getId();

		$this->logger->info("about to index $obj_str");
		$this->logger->flush();

		if(method_exists($object,"isIndexable") && !$object->isIndexable()){
			$this->textmit->removeDocument($object);
			$this->logger->debug("object $obj_str is not indexable: (removed if exists)");
			return;
		}

		foreach($ATK14_GLOBAL->getSupportedLangs() as $lang){
			$fd = $object->getFulltextData($lang);
			$stat = $this->textmit->addDocument($fd->toArray());
			if(!$stat){
				$this->logger->warn("adding $obj_str failed");
			}else{
				$this->logger->debug("successfully indexed: $obj_str");
			}
		}
	}
}
