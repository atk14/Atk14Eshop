<?php
/**
 * Model pro seznam odkazu
 */
class LinkList extends ApplicationModel implements Translatable, Rankable {

	static function GetTranslatableFields() {
		return array("label");
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
}
