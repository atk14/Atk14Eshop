<?php
class CategoryTreesController extends AdminController{

	function index(){
		$this->page_title = _("Category trees");
		$this->tpl_data["roots"] = Category::GetCategories(null);
	}

	function create_new(){
		$this->page_title = _("Create new category tree");

		$this->_save_return_uri();
		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$tags = $d["tags"];
			unset($d["tags"]);

			$d["created_by_user_id"] = $this->logged_user;
			$tree = Category::CreateNewRecord($d);
			$tree->setTags($tags);
			
			$this->flash->success(_("The category tree has been created"));
			$this->_redirect_back();
		}
	}

	function detail(){
		$this->page_title = _("Category tree");

		$options = array(
			"is_filter" => null,
			"visible" => null,
		);
		$this->tpl_data["tree"] = new CategoryTree($this->root, $options);
	}

	function set_rank() {
		if(!$this->request->post()){ return $this->_execute_action("error404"); }

		$this->render_template = false;
		$this->root->setRank($this->params->getInt("rank"));
	}

	function destroy(){
		if(!$this->request->post() || !$this->root->isDeletable()){
			return $this->_execute_action("error404");
		}

		$this->root->destroy();
	}

	function _before_filter(){
		if(in_array($this->action,array("detail","set_rank","destroy"))){
			$this->_find("root", array("class_name" => "Category"));
		}
	}
}
