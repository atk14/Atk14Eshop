<?php
class ShippingCombinationsController extends AdminController {

	function index() {
		$this->page_title = _("Kombinace doprav a plateb");
		$this->tpl_data["delivery_methods"] = DeliveryMethod::FindAll("active",true);
	}

	function edit_payment_methods() {
		$this->page_title = sprintf(_("Způsoby platby pro způsob doručení '%s'"), $this->delivery_method->getLabel());
		$this->_save_return_uri();

		$this->form->set_initial("payment_method_id", $this->delivery_method->getPaymentMethodIds());
		if ($this->request->post() && ($d=$this->form->validate($this->params))) {
			$this->delivery_method->setPaymentMethods($d["payment_method_id"]);
			return $this->_redirect_back();
		}
	}

	function edit_delivery_methods() {
		$this->page_title = sprintf(_("Způsoby dopravy pro způsob platby '%s'"), $this->payment_method->getLabel());
		$this->_save_return_uri();

		$this->form->set_initial("delivery_method_id", $this->delivery_method->getDeliveryMethodIds());
		if ($this->request->post() && ($d=$this->form->validate($this->params))) {
			$this->payment_method->setDeliveryMethods($d["delivery_method_id"]);
			return $this->_redirect_back();
		}
	}

	function _before_filter() {
		if (in_array($this->action, array("edit_payment_methods"))) {
			$this->_find("delivery_method", "delivery_method_id");
		}
		if (in_array($this->action, array("edit_delivery_methods"))) {
			$this->_find("payment_method", "payment_method_id");
		}
	}
}
