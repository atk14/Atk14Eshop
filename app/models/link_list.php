<?php
/**
 * Model pro seznam odkazu.
 *
 * LinkList by se vyhledal podle slugu, ktery je jedinecny.
 * V sablone se pak vyrenderuje vcetne link_list_items.
 *
 */
class LinkList extends ApplicationModel implements Translatable {

	static function GetTranslatableFields() {
		return array("label");
	}

	/**
	 *	$items = $list->getLinkListItems();
	 *	$items = $list->getLinkListItems($CR); // toto vrati polozky pouze pro dany region
	 *	$items = $list->getLinkListItems("CR"); // toto vrati polozky pouze pro dany region
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
