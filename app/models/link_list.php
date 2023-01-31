<?php
/**
 * Model class for a List of links
 */
class LinkList extends ApplicationModel implements Translatable, Rankable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields() {
		return array("title");
	}

	function setRank($rank){
		$this->_setRank($rank);
	}

	/**
	 *	$items = $list->getLinkListItems();
	 *	$items = $list->getLinkListItems($CZ); // toto vrati polozky pouze pro dany region
	 *	$items = $list->getLinkListItems("CZ"); // toto vrati polozky pouze pro dany region
	 */
	function getLinkListItems($region = null) {
		if(is_object($region)) {
			$region = $region->getCode();
		}

		$conditions = $bind_ar = [];

		$conditions[] = "link_list_id=:link_list";
		$bind_ar[":link_list"] = $this;

		if($region){
			$conditions[]="(regions->>:region)::BOOLEAN";
			$bind_ar[":region"] = $region;
		}

		return LinkListItem::FindAll(["conditions" => $conditions,"bind_ar" => $bind_ar]);
	}

	/**
	 * @alias
	 */
	function getItems($region = null) {
		return $this->getLinkListItems($region);
	}

	function getVisibleLinkListItems($region = null){
		$items = $this->getLinkListItems($region);
		$items = array_filter($items,function($item){ return $item->isVisible(); });
		$items = array_values($items);
		return $items;
	}

	/**
	 * @alias
	 */
	function getVisibleItems($region = null){
		return $this->getVisibleLinkListItems($region);
	}

	/**
	 *
	 *	$link_list->isEmpty();
	 *	$link_list->isEmpty(["consider_visibility" => true]); // this is default
	 *	$link_list->isEmpty(true);
	 */
	function isEmpty($options = array()){
		if(is_null($options) || is_a($options,"Region") || is_numeric($options)){
			$options = array("region" => $options);
		}
		if(!is_array($options)){
			$options = array("consider_visibility" => $options);
		}
		$options += array(
			"consider_visibility" => true,
			"region" => null,
		);
		return sizeof($options["consider_visibility"] ? $this->getVisibleLinkListItems($options["region"]) : $this->getLinkListItems($options["region"]))==0;
	}

	function isDeletable(){
		return true;
	}

	function destroy($destroy_for_real = null){
		foreach($this->getItems() as $item){
			$item->destroy($destroy_for_real);
		}

		return parent::destroy($destroy_for_real);
	}
}
