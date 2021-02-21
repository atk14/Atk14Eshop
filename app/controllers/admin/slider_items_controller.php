<?php
class SliderItemsController extends AdminController {

	function index(){
		$this->page_title = sprintf(_("Images in slider %s"),$this->slider->getName());
		$this->_add_slider_to_breadcrumbs($this->slider);

		$this->tpl_data["slider_items"] = $this->slider->getItems();
	}

	function create_new(){
		$this->_add_slider_to_breadcrumbs($this->slider);
		$this->_create_new([
			"page_title" => _("Add new image into the slider"),
			"create_closure" => function($d){
				$d["slider_id"] = $this->slider;
				return SliderItem::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_add_slider_to_breadcrumbs($this->slider_item->getSlider());
		$this->_edit();
	}

	function destroy(){
		$this->_destroy();
	}

	function set_rank(){
		$this->_set_rank();
	}

	function _before_filter(){
		if(in_array($this->action,["index","create_new"])){
			$this->_find("slider","slider_id");
		}
		if(in_array($this->action,["edit"])){
			$this->_find("slider_item");
		}
	}

	function _add_slider_to_breadcrumbs($slider){ 
		$this->breadcrumbs[] = [$slider->getName(),$this->_link_to(["action" => "sliders/edit", "id" => $slider])];
		$this->breadcrumbs[] = [_("Images"),$this->_link_to(["action" => "slider_items/index", "slider_id" => $slider])];
	}
}
