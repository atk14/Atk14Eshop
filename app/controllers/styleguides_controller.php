<?php
/**
 *	cd /path/to/your/project/
 *	git submodule add -b v3-dev --name lib/bootstrap3 https://github.com/twbs/bootstrap.git lib/bootstrap3
 */
class StyleguidesController extends ApplicationController{

	function index() {
		$this->page_title = "Style Guides";
	}
	function cart() {
		$this->page_title = "Style Guides: cart";
	}
	
}