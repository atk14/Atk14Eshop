<?php
require_once(dirname(__FILE__).'/card_list_controller.php');
class CategoriesController extends CardListController{

	function index(){
		$catalog = Category::MainRootCategory();
		if($catalog){
			$this->_redirect_to(array(
				"action" => "detail",
				"path" => $catalog->getPath(),
			));
			return;
		}
		$this->page_title = _("List of Categories");
		$this->breadcrumbs[] = _("Categories");
		$this->tpl_data["categories"] = Category::FindAll("parent_category_id",null,"visible",true);
	}

	function detail(){
		$this->_detail([
			'params' => ['path'],
		]);
		if(isset($this->tpl_data["category"])){
			$this->head_tags->setCanonical($this->_link_to(["path" => $this->tpl_data["category"]->getPath()], ["with_hostname" => true]));
		}
		if(isset($this->finder)){
			$this->datalayer->push(new CustomImpressions($this->finder->getRecords(), ["event" => "productList", "price_finder" => $this->price_finder]));
		}
	}
}
