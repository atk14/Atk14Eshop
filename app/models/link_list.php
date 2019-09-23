<?php
/**
 * Model class for a List of links
 */
class LinkList extends ApplicationModel implements Translatable {

	use TraitGetInstanceByCode;

	static function GetTranslatableFields() {
		return array("title");
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

	function isEmpty($region = null){
		return sizeof($this->getLinkListItems($region))==0;
	}
}
