<?php
class DeliveryMethodsController extends AdminController {

	function index() {
		$this->page_title = _("Způsoby dopravy");
		$this->tpl_data["delivery_methods"] = DeliveryMethod::FindAll();
	}

	function create_new() {
		$this->_create_new(array(
		"page_title" => "Vytvořit nový způsob dopravy",
		));
	}

	function edit() {
		$this->tpl_data["countries"] = Region::GetDeliveryCountriesFromAllRegions();

		$this->_edit([
			"page_title" => _("Editace způsobu dopravy")
		]);
	}

	function enable() {
		if (!$this->request->post()) {
			return $this->_redirect_to_action("error404");
		}
		$this->delivery_method->s("active", true);
		$this->flash->success(sprintf(_("Způsob dopravy '%s' zapnut"), $this->delivery_method));
		if (!$this->request->xhr()) {
			return $this->_redirect_back();
		}
	}

	function disable() {
		if (!$this->request->post()) {
			return $this->_redirect_to_action("error404");
		}
		$this->delivery_method->s("active", false);
		$this->flash->success(sprintf(_("Způsob dopravy '%s' vypnut"), $this->delivery_method));
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
			$this->_find("delivery_method");
		}
	}
}
