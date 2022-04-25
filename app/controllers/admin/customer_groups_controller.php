<?php
class CustomerGroupsController extends AdminController {

	function index(){
		$this->page_title = _("List of customer groups");

		$this->tpl_data["customer_groups"] = CustomerGroup::FindAll();
	}

	function create_new(){
		$this->_create_new([
			"page_title" => _("Create new customer group")
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => sprintf(_("Editing customer group %s"),$this->customer_group->getName()),
		]);
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("customer_group");
		}
	}
}
