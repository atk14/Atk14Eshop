<?php
class CreatorRolesController extends AdminController {

	function index(){
		$this->page_title = _("Creator roles");

		$this->tpl_data["creator_roles"] = CreatorRole::FindAll();
	}

	function create_new(){
		$this->_create_new([
			"page_title" => _("Create a new role for creators"),
		]);
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
