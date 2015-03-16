<?php
require_once(dirname(__FILE__)."/../application_base.php");

class AdminController extends ApplicationBaseController{
	function _application_before_filter(){
		parent::_application_before_filter();

		if(!$this->logged_user || !$this->logged_user->isAdmin()){
			return $this->_execute_action("error403");
		}

		$navi = new Navigation();

		foreach(array(
			array(_("Welcome screen"),			"main"),
			array(_("Articles"),						"articles"),
			array(_("Static pages"),				"static_pages"),
			array(_("Tags"),								"tags"),
			array(_("Users"),								"users"),
			array(_("Products"),						"cards,products"),
			array(_("Categories"),					"category_trees,categories"),
			array(_("Brands"),							"brands"),
			array(_("Collections"),					"collections"),
			array(_("Password recoveries"),	"password_recoveries"),
		) as $item){
			$_label = $item[0];
			$_controllers = explode(',',$item[1]); // "products,cards" => array("products","cards");
			$_action = "$_controllers[0]/index"; // "products" -> "products/index"
			$_url = $this->_link_to($_action);
			$navi->add($_label,$_url,array("active" => in_array($this->controller,$_controllers)));
		}

		$this->tpl_data["section_navigation"] = $navi;
	}
}
