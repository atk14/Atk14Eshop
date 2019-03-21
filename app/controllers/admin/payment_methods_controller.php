<?php
class PaymentMethodsController extends AdminController {

	function index() {
		$this->page_title = _("Způsoby platby");
		$this->tpl_data["payment_methods"] = PaymentMethod::FindAll();
	}

	function create_new() {
		$this->_create_new(array(
			"page_title" => "Vytvořit novou možnost platby",
		));
	}

	function edit() {
		$this->_edit([
			"page_title" => _("Editace možnosti platby"),
		]);
	}

	function enable() {
		if (!$this->request->post()) {
			return $this->_redirect_to_action("error404");
		}
		$this->payment_method->s("active", true);
		$this->flash->success(sprintf(_("Možnost platby '%s' zapnuta"), $this->payment_method));
		if (!$this->request->xhr()) {
			return $this->_redirect_back();
		}
	}

	function disable() {
		if (!$this->request->post()) {
			return $this->_redirect_to_action("error404");
		}
		$this->payment_method->s("active", false);
		$this->flash->success(sprintf(_("Možnost platby '%s' vypnuta"), $this->payment_method));
		if (!$this->request->xhr()) {
			return $this->_redirect_back();
		}
	}

	function set_rank(){
		$this->_set_rank();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter() {
		if (in_array($this->action, array("edit", "enable", "disable", "set_rank", "destroy"))) {
			$this->_find("payment_method");
		}
	}

}
