<?php
class CreatorsController extends AdminController {

	function edit(){
		$this->_edit(array(
			"page_title" => sprintf(_('Editing creator "%s"'),$this->creator->getName())
		));
	}

	function _before_filter(){
		if(in_array($this->action,["edit"])){
			$this->_find("creator");
		}
	}
}
