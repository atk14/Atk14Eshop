<?php
require_once(dirname(__FILE__).'/card_list_controller.php');
class CategoriesController extends CardListController{

	function index(){
		$catalog = Category::GetInstanceByCode("catalog");
		if($catalog){
			$this->_redirect_to(array(
				"action" => "detail",
				"path" => $catalog->getPath(),
			));
			return;
		}
		$this->page_title = _("List of Categories");
		$this->breadcrumbs[] = _("Categories");

		if($catalog = Category::FindByCode("catalog")){
			$this->_redirect_to([
				"action" => "detail",
				"path" => $catalog->getPath(),
			]);
			return;
		}

		$this->tpl_data["categories"] = Category::FindAll("parent_category_id",null,"visible",true);
	}

	function detail(){
		$this->_detail();
	}
}
