<?php
class SystemParametersController extends AdminController {

	function index(){
		$this->page_title = _("System preferences");

		$tree = [];
		foreach(SystemParameter::FindAll(["order_by" => "code ASC"]) as $sp){
			$code = $sp->getCode();

			$keys = [];
			$ref = &$tree;
			foreach(explode(".",$code) as $key){
				$keys[] = $key;
				if(!isset($ref[$key])){
					$ref[$key] = [
						"key" => $key,
						"system_parameter" => null,
						"children" => [],
					];
				}

				if(join(".",$keys)==$code){
					$ref[$key]["system_parameter"]  = $sp;
				}

				$ref = &$ref[$key]["children"];
			}
		}
		$this->tpl_data["tree"] = $tree;

		$this->tpl_data["system_parameters"] = SystemParameter::FindAll(["order_by" => "code ASC"]);
	}

	function edit(){
		$this->page_title = sprintf(_("Editing parameter %s"),$this->system_parameter->getCode());

		$this->form->prepare_for($this->system_parameter);
		$this->form->set_initial($this->system_parameter);
		$this->_save_return_uri();

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			if($d==$this->form->get_initial() || $this->system_parameter->isReadOnly()){
				$this->flash->notice(_("Nothing has been changed"));
			}else{
				$this->system_parameter->s($d);
				$this->flash->success(_("Parameter value has been updated"));
			}
			$this->_redirect_back();
		}
	}

	function _before_filter(){
		if($this->action=="edit"){
			$this->_find("system_parameter");
		}
	}
}
