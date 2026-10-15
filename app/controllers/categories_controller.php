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
			$link_params = ["path" => $this->tpl_data["category"]->getPath()];
			if(isset($this->pager)){
				$offset_name = $this->pager->options['offset_name'];
				$limit_name = $this->pager->options['limit_name'];
				if($this->params->defined($offset_name)){ $link_params[$offset_name] = $this->pager->getOffset(); }
				if($this->params->defined($limit_name)){ $link_params[$limit_name] = $this->pager->getLimit(); }
			}
			$this->head_tags->setCanonical($this->_link_to($link_params, ["with_hostname" => true]));
		}
		if(isset($this->finder)){
			$this->datalayer->push(new DatalayerGenerator\MessageGenerators\GA4\ViewItemList(null, ["items" => $this->finder->getRecords()], ["price_finder" => $this->price_finder]));
		}
	}
}
