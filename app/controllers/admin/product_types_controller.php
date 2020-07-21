<?php
class ProductTypesController extends AdminController {

	function index() {
		$this->page_title = _("Listing product types");
		$this->tpl_data["product_types"] = ProductType::FindAll();
	}

	function create_new() {
		$this->_create_new(array(
			"page_title" => _("New product type"),
		));
	}

	function edit() {
		$this->_edit(array(
			"page_title" => _("Editing of the product type"),
		));
	}

	function destroy() {
		$this->_destroy();
	}

	function set_rank() {
		if(!$this->request->post()){ return $this->_execute_action("error404"); }

		$this->render_template = false;
		$this->product_type->setRank($this->params->getInt("rank"));
	}

	function _before_filter(){
		if(in_array($this->action,array("edit","destroy","set_rank"))){
			$this->_find("product_type");
		}
	}
}
