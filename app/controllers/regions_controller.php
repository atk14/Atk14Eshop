<?php
class RegionsController extends ApplicationController {

	function set_region(){
		if(!$this->request->post() || !($region = $this->_find("region"))){
			return $this->_redirect_back();
		}

		if($region->getId()==$this->current_region->getId()){
			return $this->_redirect_back();
		}

		$this->permanentSession->s("region_id",$region->getId());

		$this->_redirect_back();
	}

	function _redirect_back($default = "main/index"){
		parent::_redirect_back($default);
	}
}
