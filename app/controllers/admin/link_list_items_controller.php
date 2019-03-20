<?php
class LinkListItemsController extends AdminController {

	function index() {
		$this->page_title = sprintf(_("Položky v seznamu odkazů '%s'"), $this->link_list->getName());

		$this->tpl_data["finder"] = LinkListItem::Finder(array(
			"conditions" => array("link_list_id=:link_list_id"),
			"bind_ar" => array(
				":link_list_id" => $this->link_list,
			),
			"limit" => null,
		));
		$this->breadcrumbs[] = $this->link_list->getName();
	}

	function create_new() {
		$this->_create_new([
			"page_title" => sprintf(_("Nová položka v seznamu odkazů '%s'"),$this->link_list->getName()),
			"create_closure" => function($d){
				$d["link_list_id"] = $this->link_list;
				return LinkListItem::CreateNewRecord($d);
			}

		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => sprintf(_("Editace položky v seznamu odkazů '%s'"),$this->link_list_item->getLabel()),
		]);
	}

	function set_rank() {
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter() {
		if (in_array($this->action, array("index", "create_new"))) {
			$this->_find("link_list", "link_list_id");
		}
		if (in_array($this->action, array("edit","set_rank", "destroy"))) {
			$this->_find("link_list_item");
		}
	}
}
