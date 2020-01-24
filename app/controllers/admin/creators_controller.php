<?php
class CreatorsController extends AdminController {

	function edit(){
		$this->_edit();
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("creator");
		}
	}
}
