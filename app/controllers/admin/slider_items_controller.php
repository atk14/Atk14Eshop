<?php
class SliderItemsController extends AdminController {

	function create_new(){
		$this->_create_new([
			"page_title" => _("Add new image into the slider"),
			"create_closure" => function($d){
				$d["slider_id"] = $this->slider;
				return SliderItem::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_edit();
	}

	function destroy(){
		$this->_destroy();
	}

	function set_rank(){
		$this->_set_rank();
	}

	function _before_filter(){
		if($this->action=="create_new"){
			$this->_find("slider","slider_id");
		}
	}
}
