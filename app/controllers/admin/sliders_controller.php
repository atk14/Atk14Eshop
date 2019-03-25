<?php
class SlidersController extends AdminController {

	function index(){
		$this->page_title = _("Seznam sliderů");
		$sliders = $this->tpl_data["sliders"] = Slider::FindAll();

		if(sizeof($sliders)==1){
			$this->_redirect_to([
				"action" => "edit",
				"id" => $sliders[0],
			]);
		}
		
	}

	function edit(){
		$this->_edit([
			"page_title" => $this->slider->getName(),
		]);
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("slider");
		}
	}
}
