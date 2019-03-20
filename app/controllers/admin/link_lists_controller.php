<?php
class LinkListsController extends AdminController {

	function index() {
		$this->page_title = _("Seznamy odkazů");
		$this->tpl_data["finder"] = LinkList::Finder(array(
			"limit" => null,
		));
	}

	function create_new(){
		$this->page_title = _("Nový seznam odkazů");
		
		$this->_save_return_uri();

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$this->link_list = $link_list = LinkList::CreateNewRecord($d);
			$this->flash->success(_("Seznam odkazů vytvořen"));
			return $this->_redirect_to(array(
				"controller" => "link_list_items",
				"action" => "index",
				"link_list_id" => $link_list,
			));
		}
	}

	function edit(){
		$this->page_title = sprintf(_("Editace seznamu odkazů '%s'"),h($this->link_list->getName()));
		
		$this->_save_return_uri();
		$this->form->set_initial($this->link_list);

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$this->link_list->s($d);
			$this->flash->success(_("Změny byly uloženy"));
			$this->_redirect_back();
		}
	}

	function destroy(){
		$this->_destroy($this->link_list);
	}

	function _before_filter(){
		if(in_array($this->action,array("edit","destroy"))){
			$this->_find("link_list");
		}
	}
}
