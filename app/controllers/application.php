<?php
require_once(__DIR__."/application_base.php");

class ApplicationController extends ApplicationBaseController{

	function error404(){
		if($this->request->xhr()){
			return parent::error404();
		}

		if($this->_redirected_on_error404()){
			return;
		}

		$page = Page::GetInstanceByCode("error404");
		if(!$page){
			return parent::error404();
		}

		$this->page_title = $page->getTitle();
		$this->page_description = $page->getPageDescription();
		$this->_add_page_to_breadcrumbs($page);
		$this->response->setStatusCode(404);
		$this->tpl_data["page"] = $page;
		$this->template_name = "pages/detail";
	}
	
	function _add_page_to_breadcrumbs($page){
		$pages = array($page);
		$p = $page;
		while($parent = $p->getParentPage()){
			$p = $parent;
			if($p->getCode()=="homepage"){ continue; }
			$pages[] = $p;
		}
		$pages = array_reverse($pages);
		foreach($pages as $p){
			$this->breadcrumbs[] = array($p->getTitle(),$this->_link_to(array("action" => "pages/detail", "id" => $p)));
		}
	}

	function _add_card_to_breadcrumbs($card){
		$primary_category = $card->getPrimaryCategory();
		if($primary_category){
			foreach($primary_category->getPathOfCategories() as $c){
				$this->breadcrumbs[] = array($c->getName(),$this->_link_to(array("action" => "categories/detail", "path" => $c->getPath())));
			}
		}
		$this->breadcrumbs[] = array($card->getName(),$this->_link_to(array("action" => "cards/detail", "id" => $card->getId())));
	}

	function _add_user_detail_breadcrumb(){
		if(!$this->logged_user){ return; }

		$title = _("My account");
		
		if("$this->controller/$this->action"=="users/detail"){
			$this->breadcrumbs[] = $title;
			return;
		}

		$this->breadcrumbs[] = [$title,"users/detail"];
	}

	function _add_order_to_breadcrumbs($order){
		if($this->logged_user){
			// neprihlaseny uzivatel nema pristup na index
			$this->breadcrumbs[] = [_("Objednávky"),"orders/index"];
		}
		$link = null;
		if(is_null($order->g("user_id"))){
			$link = $this->_link_to(["action" => "orders/detail", "token" => $order->getToken()]);
		}else{
			if($order->belongsToUser($this->logged_user)){
				$link = $this->_link_to(["action" => "orders/detail", "id" => $order->getId()]);
			}
		}
		$this->breadcrumbs[] = [sprintf(_("Objednávka %s"),$order->getOrderNo()),$link];
	}

	function _application_before_filter() {
		// Here, the $this->lazy_loader can be filled up with something

		parent::_application_before_filter();
	}

	// Navigace u vytvareni objednavky
	function _prepare_checkout_navigation(){
		$navi = new Menu14();
		$navi[] = [_("Basket"),"baskets/edit"];
		$navi[] = [_("Shipping and payment"),["checkouts/set_payment_and_delivery_method"]];
		$navi[] = [_("Delivery data"),["checkouts/user_identification","checkouts/set_billing_and_delivery_data"]];
		$navi[] = [_("Summary"),["checkouts/summary","checkouts/finish"]];

		$active_item_passed = false;
		foreach($navi as $item){
			if($item->isActive()){
				$active_item_passed = true;
				continue;
			}
			if($active_item_passed){
				$item->setDisabled();
			}
		}

		$this->tpl_data["checkout_navigation"] = $navi;
		return $navi;
	}

	/**
	 * Vyhleda objednavku podle parametru id nebo token
	 */
	function _find_order($options = []){
		$options += [
			"soft_verification" => false,
			"parameter_prefix" => "", // "order_"
		];

		$soft_verification = $options["soft_verification"];
		$prefix = $options["parameter_prefix"];

		if($this->logged_user && ($order = Order::FindById($this->params->getInt("{$prefix}id"))) && $order->belongsToUser($this->logged_user)){
			return $order;
		}

		if(!$order = Order::GetInstanceByToken($this->params->getString("{$prefix}token"))){
			return;
		}

		if($soft_verification){
			return $order;
		}

		if(is_null($order->g("user_id")) || $order->belongsToUser($this->logged_user)){
			return $order;
		}
	}
}
