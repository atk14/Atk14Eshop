<?php
class RegionsController extends AdminController {

	function index(){
		$this->page_title = _("List of selling regions");
		$this->tpl_data["regions"] = Region::FindAll();
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editing selling region"),
		]);
	}

}
