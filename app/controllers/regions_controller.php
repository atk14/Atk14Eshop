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
		
		// here is an attempt to redirect user to the default language of the selected region
		$uri = $this->_get_return_uri();
		$uri = preg_replace('/^(https?:\/\/[^\/]+)/','',$uri); // "http://atk14eshop.localhost/obchod/" -> "/obchod/"
		$ary = Atk14Url::RecognizeRoute($uri);
		if($ary && !preg_match("/^error/",$ary["action"])){
			$uri = $this->_link_to([
				"namespace" => $ary["namespace"],
				"controller" => $ary["controller"],
				"action" => $ary["action"],
				"lang" => $region->getDefaultLanguage(),
			] + $ary["get_params"]);
			$this->_redirect_to($uri);
			return;
		}

		$this->_redirect_back();
	}

	function _redirect_back($default = "main/index"){
		parent::_redirect_back($default);
	}
}
