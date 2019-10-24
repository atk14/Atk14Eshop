<?php
class FulltextIndexerRobot extends ApplicationRobot {

	function run(){
		$this->textmit = new \Textmit\Client();
		$this->now = $now = date("Y-m-d H:i:s");

		$this->logger->info("using stage: ".$this->textmit->getStage());
		$this->logger->flush();

		$RECIPE_ITEMS = [
			"Page" => [],
			"Article" => ["conditions" => ["published_at<=:now"], "bind_ar" => [":now" => $now]],
			"Card" => ["conditions" => ["visible","NOT deleted"]],
			"Category" => [
				"conditions" => [
					"visible",
					"NOT is_filter",
					"pointing_to_category_id IS NULL",
					"parent_category_id IS NOT NULL",
					"(SELECT COUNT(*) FROM categories p WHERE p.id=parent_category_id AND (p.is_filter OR NOT p.visible))=0"
				]
			],
			"Store" => ["conditions" => "visible"],
		];

		foreach($RECIPE_ITEMS as $class => $options){
			foreach($class::FindAll($options) as $object){
				$this->_indexObject($object);
			}
		}

		$deleted = $this->textmit->removeObsoleteDocuments(date("Y-m-d H:i:s",time() - 60 * 60 * 12)); // 12 hours
		$this->logger->info("obsolete documents deleted: $deleted");
	}

	function _indexObject($object){
		global $ATK14_GLOBAL;

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
