<?php
class SlidersController extends AdminController {

	function index(){
		$this->page_title = _("List of image sliders");

		$this->tpl_data["sliders"] = Slider::FindAll();
	}

	function create_new(){
		$this->_create_new();
	}

	function edit(){
		$this->_edit([
			"page_title" => $this->slider->getName(),
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
			$this->_find("slider");
		}
	}
}
