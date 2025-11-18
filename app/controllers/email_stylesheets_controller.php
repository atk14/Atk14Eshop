<?php
class EmailStylesheetsController extends ApplicationController {

	function detail(){
		global $ATK14_GLOBAL;
		$theme_ar = $ATK14_GLOBAL->getConfig("theme/email");
		$this->tpl_data += $theme_ar;

		$this->render_layout = false;
		$this->response->setContentType("text/css");
	}
}
