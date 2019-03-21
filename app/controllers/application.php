<?php
require_once(__DIR__."/application_base.php");

class ApplicationController extends ApplicationBaseController{
	
	function _add_page_to_breadcrumbs($page){
		$pages = array($page);
		$p = $page;
		while($parent = $p->getParentPage()){
			$pages[] = $parent;
			$p = $parent;
		}
		$pages = array_reverse($pages);
		foreach($pages as $p){
			$this->breadcrumbs[] = array($p->getTitle(),$this->_link_to(array("action" => "pages/detail", "id" => $p)));
		}
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

		// Veci do lazy_loaderu pridame pred volani parent::_application_before_filter(), protoze
		// tam muze dojit k _execute_action() a tak uz to potrebujeme mit k dipozici

		$region = $this->_get_current_region();

		$this->lazy_loader["main_menu"] = function() use($region){
			$menu = new Menu14();
			$ll = LinkList::FindByCode("main");
			if($ll){
				foreach($ll->getItems($region) as $link){
					$menu[] = [$link->getLabel(),$link->getUrl()];
				}
			}
			return $menu;
		};

		$this->lazy_loader["footer_1_menu"] = function() use($region){
			$menu = new Menu14();
			$ll = LinkList::FindByCode("footer_1");
			if($ll){
				$submenu = $menu->add($ll->getLabel());
				foreach($ll->getItems($region) as $link){
					$submenu[] = [$link->getLabel(),$link->getUrl()];
				}
			}
			return $menu;
		};

		$this->lazy_loader["footer_2_menu"] = function() use($region){
			$menu = new Menu14();
			$ll = LinkList::FindByCode("footer_2");
			if($ll){
				$submenu = $menu->add($ll->getLabel());
				foreach($ll->getItems($region) as $link){
					$submenu[] = [$link->getLabel(),$link->getUrl()];
				}
			}
			return $menu;
		};

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
