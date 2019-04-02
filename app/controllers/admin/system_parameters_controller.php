<?php
class SystemParametersController extends AdminController {

	function index(){
		$this->page_title = _("System preferences");

		$this->tpl_data["system_parameters"] = SystemParameter::FindAll(["order_by" => "code ASC"]);
	}

	function edit(){
		$this->page_title = sprintf(_("Editace parametru %s"),$this->system_parameter->getCode());

		$this->form->prepare_for($this->system_parameter);
		$this->form->set_initial($this->system_parameter);
		$this->_save_return_uri();

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$this->system_parameter->s($d);
			$this->flash->success(_("Hodnota parametru byla aktualizována"));
			$this->_redirect_back();
		}
	}

	function _before_filter(){
		if($this->action=="edit"){
			$this->_find("system_parameter");
		}
	}
}
