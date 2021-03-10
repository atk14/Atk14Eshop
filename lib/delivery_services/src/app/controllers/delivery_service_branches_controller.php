<?php
class DeliveryServiceBranchesController extends ApplicationController {

	function set_branch() {
		$this->tpl_data["branch_selector_form"] = $this->_get_form("branch_selector_form");

		$this->_save_return_uri();
		$this->page_title = sprintf(_("%s - výběr výdejního místa"), $this->delivery_method->getDeliveryService()->getName());

		if ($this->request->post() && ($d=$this->form->validate($this->params))) {
			$dsb = $d["delivery_service_branch_id"];
			$dsb && ($d["delivery_method_id"] = $this->delivery_method);
			$dsb && ($d["delivery_method_data"] = $dsb->getDeliveryMethodData());
			unset($d["delivery_service_branch_id"]);
			$this->basket->s($d);

			return $this->_redirect_back();
		}
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
