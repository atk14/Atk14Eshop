<?php
class DeliveryServiceBranchesController extends ApplicationController {

	function set_branch() {
		$this->tpl_data["branch_selector_form"] = $this->_get_form("branch_selector_form");

		$this->_save_return_uri();
		$this->page_title = sprintf(_("%s - výběr výdejního místa"), $this->delivery_method->getDeliveryService()->getName());
		$this->tpl_data["widget_template_html"] = $this->_get_selector_template_name("html",$dialog_provider);
		$this->tpl_data["widget_template_js"] = $this->_get_selector_template_name("js");

		$this->tpl_data["dialog_provider"] = $dialog_provider; // "default", "zasilkovna", "cp_balikovna"...

		if ($this->request->post() && ($d=$this->form->validate($this->params))) {
			$dsb = $d["delivery_service_branch_id"];
			if(!in_array($dsb->getCountry(),$this->basket->getDeliveryCountriesAllowed())){
				$this->form->set_error(_("Nepřípustná země pro doručení"));
				return;
			}
			$dsb && ($d["delivery_method_id"] = $this->delivery_method);
			$dsb && ($d["delivery_method_data"] = $dsb->getDeliveryMethodData());
			unset($d["delivery_service_branch_id"]);
			$this->basket->s($d);

			return $this->_redirect_back();
		}
	}

	function _get_selector_template_name($type,&$provider = "") {
		$delivery_service = $this->delivery_method->getDeliveryService();

		$provider = "default";
		if ($delivery_service) {
			$_provider = (new String4($delivery_service->getCode()))->replace("-","_");
			if ($this->_selector_template_exists($type, $_provider)) {
				$provider = $_provider;
			}
		}

		return $this->_build_selector_template_name($type, $provider);
	}

	protected function _build_selector_template_name($type, $provider) {
		$template_name = sprintf("widget_%s_%s", $type, $provider);
		return $template_name;
	}

	protected function _selector_template_exists($type, $provider) {
		global $ATK14_GLOBAL;
		$_template_name = sprintf("_widget_%s_%s.tpl", $type, $provider);
		$filename = $ATK14_GLOBAL->getApplicationPath()."views/".$this->controller."/".$_template_name;

		return (file_exists($filename) && is_file($filename));
	}

	function _before_filter() {
		$dm = $this->_find("delivery_method","delivery_method_id");
		if($dm && !$dm->getDeliveryService()){
			return $this->_execute_action("error404");
		}
		$this->breadcrumbs[] = _("Nákupní košík");
		$this->_prepare_checkout_navigation();
	}
}
