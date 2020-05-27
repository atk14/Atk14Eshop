<?php
class StyleguidesRouter extends Atk14Router {

	function setUp(){
		$this->addRoute("/styleguides/","$this->default_lang/styleguides/index");
		$this->addRoute("/styleguides/<id>/","$this->default_lang/styleguides/detail");
	}
}
