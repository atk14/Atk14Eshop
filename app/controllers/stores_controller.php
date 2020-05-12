<?php
class StoresController extends ApplicationController {

	function index(){
		$this->page_title = _("List of stores");
		$this->breadcrumbs[] = _("Stores");
		$this->tpl_data["stores"] = Store::FindAll("visible",true);
	}

	function detail(){
		if(!$this->store->isVisible()){
			return $this->_execute_action("error404");
		}
		$this->breadcrumbs[] = array(_("Stores"),"stores/index");
		$this->page_title = $this->breadcrumbs[] = $this->store->getName();
	}

	function _before_filter(){
		if($this->action=="detail"){
			$this->_find("store");
		}
	}
}
