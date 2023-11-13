<?php
class DeliveryServiceBranchesController extends ApplicationController {

	function set_branch() {
		$this->tpl_data["branch_selector_form"] = $this->_get_form("branch_selector_form");

		$this->_save_return_uri();
		$this->page_title = sprintf(_("%s - výběr výdejního místa"), $this->delivery_method->getDeliveryService()->getName());
		$this->tpl_data["widget_template_html"] = $this->_get_selector_template_name("html");
		$this->tpl_data["widget_template_js"] = $this->_get_selector_template_name("js");

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

	function _get_selector_template_name($type) {

		$delivery_service = $this->delivery_method->getDeliveryService();
		$_provider_template = "default";
		$_widget_template_name = "widget_{$type}_default";

		if ($delivery_service) {
			$_delivery_service_code = (new String4($delivery_service->getCode()))->replace("-","_");
		}

		if (!$this->_selector_template_exists($type, $_delivery_service_code)) {
			return $this->_build_selector_template_name($type, "default");
		}
		$template_name = $this->_build_selector_template_name($type, $_delivery_service_code);

		return $template_name;
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
