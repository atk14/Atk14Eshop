<?php
class DeliveryAddressesController extends ApplicationController {

	function index(){
		$this->page_title = _("Seznam doručovacích adres");

		$this->tpl_data["delivery_addresses"] = DeliveryAddress::GetInstancesByUser($this->logged_user,$this->current_region);
	}

	function create_new(){
		$this->page_title = $this->breadcrumbs[] = _("Nová doručovací adresa");

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$d["user_id"] = $this->logged_user;

			DeliveryAddress::CreateNewRecord($d);
			$this->flash->success(_("Doručovací adresa byla vytvořena"));
			$this->_redirect_to("index");
		}
	}

	function edit(){
		$this->page_title = $this->breadcrumbs[] = _("Úprava adresy");

		$this->form->set_initial($this->delivery_address);

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$this->delivery_address->s($d);
			$this->flash->success(_("Změny byly uloženy"));
			$this->_redirect_to("index");
		}
	}

	function destroy(){
		if(!$this->request->post()){ return $this->_execute_action("error404"); }

		$this->delivery_address->destroy();

		if(!$this->request->xhr()){
			$this->flash->success(_("Doručovací adresa byla smazána"));
			$this->_redirect_to("index");
		}
	}

	function _before_filter(){
		$this->_add_user_detail_breadcrumb();
		$this->breadcrumbs[] = [_("Doručovací adresy"),"delivery_addresses/index"];

		if(in_array($this->action,["edit","detail","destroy"])){
			$delivery_address = $this->_just_find("delivery_address");
			if(!$delivery_address || $this->logged_user->getId()!==$delivery_address->getUserId()){
				return $this->_execute_action("error404");
			}
			$this->delivery_address = $delivery_address;
		}
	}

	function _logged_user_required(){
		return true;
	}
}
