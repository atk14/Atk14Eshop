<?php
class UserSpecialPricelistsController extends AdminController {

	function create_new(){
		$user = $this->user;
		$this->_add_user_to_breadcrumbs($user);
		$this->_create_new([
			"page_title" => sprintf(_("Adding special pricelist to user %s"),"$user"),
			"create_closure" => function($d) use($user){
				$user->getSpecialPricelistsLister()->append($d["pricelist_id"]);
			}
		]);
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		if(in_array($this->action,["create_new"])){
			$this->_find("user","user_id");
		}
	}
}
