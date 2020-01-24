<?php
class CreatorRolesController extends AdminController {

	function index(){
		$this->page_title = _("Creator roles");

		$this->tpl_data["creator_roles"] = CreatorRole::FindAll();
	}

	function create_new(){
		$this->_create_new();
	}

	function edit(){
		$this->_edit();
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}


}
