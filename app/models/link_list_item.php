<?php
class LinkListItem extends ApplicationModel implements Rankable, Translatable {

	use TraitUrlParams;
	use TraitRegions;

	static function GetTranslatableFields() {
		return array("title");
	}

	function setRank($new_rank) {
		return $this->_setRank($new_rank, array(
			"link_list_id" => $this->getLinkList(),
		));
	}

	function getLinkList() {
		return Cache::Get("LinkList", $this->getLinkListId());
	}

	function isVisible(){ return $this->g("visible"); }

	/**
	 * Tries to determine the object this link is pointing to
	 *
	 *	$target = $item->getTargetObject();
	 *	if($target && is_a($target,"Page")){
	 *		// well, $target is a page :)
	 *  }
	 */
	function getTargetObject(){
		$params = $this->g("url_params");
		if($params){ $params = json_decode($params,true); }
		if(!$params){ return; }

		if($params["namespace"]!==""){ return; }
		switch("$params[controller]/$params[action]"){
			case "pages/detail":
				return Cache::Get("Page",(int)$params["id"]);
			case "categories/detail":
				return Category::GetInstanceByPath($params["path"]);
			case "main/index":
				return Page::GetInstanceByCode("homepage");
		}
	}

	/**
	 * Returns auto generated submenu
	 *
	 * Returns null when there is no submenu for this item.
	 *
	 * @return Menu14
	 */
	function getSubmenu($options = array()){
		$options += array(
			"reasonable_max_items_count" => null, // null will be returned when the count of submenu items exceeds this value
		);

		$params = $this->g("url_params");
		if($params){ $params = json_decode($params,true); }
		$target = $this->getTargetObject();

		$menu = new Menu14();

		if(is_a($target,"Page")){
			$menu->setMeta("image_url",$target->getImageUrl());
			foreach($target->getVisibleChildPages() as $chi){
				$item = $menu->addItem($chi->getTitle(),Atk14Url::BuildLink(["namespace" => "", "action" => "pages/detail", "id" => $chi]));
				$item->setMeta("image_url",$chi->getImageUrl());
			}
		}

		if(is_a($target,"Category")){
			$menu->setMeta("image_url",$target->getImageUrl());
			foreach($target->getVisibleChildCategories() as $chi){
				if($chi->isFilter()){ continue; }
				$path = $target->getPath()."/".$chi->getSlug(); // This must work for aliases
				$item = $menu->addItem($chi->getName(),Atk14Url::BuildLink(["namespace" => "", "action" => "categories/detail", "path" => $path]));
				$item->setMeta("image_url",$chi->getImageUrl());

			}
		}

		if($params && $params["namespace"]==="" && $params["controller"]==="brands" && $params["action"]==="index"){
			foreach(Brand::FindAll() as $brand){
				$item = $menu->addItem($brand->getName(),Atk14Url::BuildLink(["namespace" => "", "action" => "brands/detail", "id" => $brand]));
				$item->setMeta("image_url",$brand->getLogoUrl());
			}
		}

		if($menu->isEmpty()){
			return null;
		}

		if($options["reasonable_max_items_count"] && sizeof($menu->getItems())>$options["reasonable_max_items_count"]){
			return null;
		}

		return $menu;
	}
}
