<?php
require_once(__DIR__."/../application_base.php");
require_once(__DIR__."/../trait_crud_actions.php");

class AdminController extends ApplicationBaseController{

	use TraitCrudActions;

	function _application_before_filter(){
		parent::_application_before_filter();

		$this->breadcrumbs[] = array(_("Administration"), $this->_link_to(array("namespace" => "admin", "action" => "main/index")));

		if(!$this->logged_user || !$this->logged_user->isAdmin()){
			if($this->controller=="main" && $this->action=="index" && $this->request->get() && !$this->logged_user){
				// in the case that this is the main page of administration
				// we can simply redirect not-logged user to the login form
				return $this->_redirect_to(array(
					"namespace" => "",
					"action" => "logins/create_new",
					"return_uri" => $this->request->getUri(),
				));
			}

			return $this->_execute_action("error403");
		}

		$navi = new Menu14();

		$items = array(
			array(_("Welcome screen"),			"main"),
			array(_("Orders"),							"orders,order_order_statuses,order_items,order_campaigns,order_vouchers"),
			array(_("Articles"),						"articles"),
			array(_("Pages"),								"pages"),
			array(_("Link lists"),					"link_lists,link_list_items"),
			array(_("Image sliders"),				"sliders,slider_items"),
			array(_("Tags"),								"tags"),
			array(_("Users"),								"users,user_special_pricelists"),
			array(_("Products"),						"cards,products,card_sections,related_cards,consumables,accessories,card_filters,technical_specifications,card_cloning,card_merging,card_creators,creator_roles,creators,digital_contents"),
			"customer_reviews" => [_("Customer reviews"), "customer_reviews"],
			array(_("Product types"),				"product_types"),
			array(_("Categories"),					"category_trees,categories,category_cards"),
			array(_("Vouchers"),						"vouchers"),
			array(_("Campaigns"),						"campaigns"),
			array(_("Brands"),							"brands"),
			// array(_("Collections"),					"collections"), // Collections are obsolete in Atk14Eshop
			array(_("Stores"),							"stores,special_opening_hours"),
			array(_("Warehouses"),					"warehouses,warehouse_items"),
			array(_("Price lists"),					"pricelists,pricelist_items"),
			array(_("Special price lists"), "special_pricelists,special_pricelist_items"),
			array(_("Discounts"),						"discounts"),
			array(_("Delivery methods"),		"delivery_methods,delivery_method_country_specifications"),
			array(_("Payment methods"),			"payment_methods"),
			array(_("Combination of transports and payments"), "shipping_combinations"),
			array(_("Currencies"),					"currencies"),
			array(_("VAT rates"),						"vat_rates"),
			array(_("Password recoveries"),	"password_recoveries"),
			array(_("Newsletter subscribers"), "newsletter_subscribers"),
			array(_("404 Redirections"),			"error_redirections"),
			array(_("Order statuses"),				"order_statuses"),
			array(_("Selling regions"),				"regions"),
			array(_("Customer groups"),				"customer_groups"),
			array(_("Bank accounts"),					"bank_accounts"),
			array(_("Cookie consent"),				"cookie_consents,cookie_consent_categories,cookie_consent_statistics"),
			array(_("System preferences"),		"system_parameters"),
		);
		if(!CUSTOMER_REVIEWS_ENABLED){ unset($items["customer_reviews"]); }
		foreach($items as $item){
			$_label = $item[0];
			$_controllers = explode(',',$item[1]); // "products,cards" => array("products","cards");
			$_action = "$_controllers[0]/index"; // "products" -> "products/index"
			$_url = $this->_link_to($_action);
			$navi->add($_label,$_url,array("active" => in_array($this->controller,$_controllers)));
			if(in_array($this->controller,$_controllers)){
				$this->breadcrumbs[] = array($_label,$this->_link_to("$_controllers[0]/index"));
			}
		}

		$this->tpl_data["section_navigation"] = $navi;
	}

	function _before_render(){
		// auto breadcrumbs
		if($this->action!="index" && !preg_match('/^error/',$this->action)){ // error404 or error403
			$this->breadcrumbs[] = $this->page_title;
		}
		parent::_before_render();
	}

	function _add_page_to_breadcrumbs($page){
		if(!$page){ return; }
		$pages = [$page];
		while($parent = $page->getParentPage()){
			$pages[] = $parent;
			$page = $parent;
		}
		foreach(array_reverse($pages) as $p){
			$this->breadcrumbs[] = [$p->getTitle(),$this->_link_to(["action" => "pages/edit", "id" => $p])];
		}
	}

	function _add_gallery_to_breadcrumbs($gallery){
		if(!$gallery){ return; }
		$title = _("Fotogalerie");
		if($gallery->getTitle()){
			$title .= ": ".$gallery->getTitle();
		}
		$link = ["action" => "galleries/detail", "id" => $gallery];
		$this->_add_something_to_breadcrumbs($title,$link);
	}

	function _add_card_to_breadcrumbs($card){
		if(!$card){ return; }
		$this->breadcrumbs[] = array($card->getName(),$this->_link_to(array("action" => "cards/edit", "id" => $card)));
	}

	function _add_product_to_breadcrumbs($product){
		if(!$product){ return; }
		$title = $product->getLabel() ? $product->getLabel() : "$product";
		$this->breadcrumbs[] = array($title,$this->_link_to(array("action" => "products/edit", "id" => $product)));
	}

	function _add_category_to_breadcrumbs($category){
		if(!$category){ return; }

		$root = $category->getRootCategory();
		$this->breadcrumbs[] = array(_("Category tree"),$this->_link_to(array("action" => "category_trees/detail", "id" => $root)));

		// breadcrumbs
		$ancestors = array();
		$c = $category;
		while($p = $c->getParentCategory()){
			$ancestors[] = $p;
			$c = $p;
		}
		$ancestors = array_reverse($ancestors);
		$ancestors[] = $category;
		foreach($ancestors as $a){
			$name = $a->getName();
			if($a->isFilter()){ $name = _("filter").": $name"; }
			if($a->isAlias()){ $name = _("link").": $name"; }

			$flags = [];
			if(!$a->isVisible(false)){ $flags[] = _("invisible"); }
			
			// here is the place for adding custom flags...

			if($flags){
				$name .= " (".join(", ",$flags).")";
			}

			$this->breadcrumbs[] = array(
				$name,
				$this->_link_to(array("action" => "categories/edit", "id" => $a))
			);
		}
	}

	function _add_order_to_breadcrumb($order){
		if(!$order){ return; }

		$this->breadcrumbs[] = [
			sprintf(_("Objednávka %s"),$order->getOrderNo()),
			$this->_link_to(["action" => "orders/detail", "id" => $order])
		];
		$this->breadcrumbs[] = [
			sprintf(_("Editace objednávky %s"),$order->getOrderNo()),
			$this->_link_to(["action" => "orders/edit", "id" => $order])
		];
	}

	function _add_user_to_breadcrumbs($user){
		if(!$user){ return; }

		$this->breadcrumbs[] = [sprintf(_("Editing user %s"),$user),$this->_link_to(["action" => "users/edit", "id" => $user])];
	}
}
