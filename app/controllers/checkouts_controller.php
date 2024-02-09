<?php
class CheckoutsController extends ApplicationController {

	function set_payment_and_delivery_method(){
		$this->page_title = _("Shipping and payment");
		if(!is_null($this->basket->getDeliveryMethodId()) || !is_null($this->basket->getPaymentMethodId())){
			$this->form->set_initial($this->basket);
		}
		$this->form->set_attr("data-rules", ShippingCombination::GetRules(array("format" => "json")));

		if(sizeof($this->_get_allowed_regions())>1){
			$this->tpl_data["set_region_form"] = $this->_get_form("regions/set_region");
		}

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$this->basket->s($d);
			$this->_redirect_to("user_identification");
		}
		$this->datalayer->push(new DatalayerGenerator\MessageGenerators\GA4\BeginCheckout($this->basket, ["items" => $this->basket->getBasketItems()]));
	}

	function user_identification(){
		if($this->logged_user){
			return $this->_redirect_to("set_billing_and_delivery_data");
		}

		if($this->basket->hasDeliveryAddressSet()){
			// Zakaznik neni prihlaseny, ale dorucovaci adresu uz nastavil -> tj. vybral si zpusob nakup bez registrace
			return $this->_redirect_to("set_billing_and_delivery_data");
		}

		$this->page_title = _("Přihlášení uživatele");

		$login_form = $this->_get_form("logins/create_new");
		$login_form->set_action($this->_link_to(["action" => "logins/create_new", "return_uri" => $this->request->getUri()]));
		$this->tpl_data["login_form"] = $login_form;
	}

	function set_billing_and_delivery_data(){
		if(!$this->basket->getPaymentMethod() || !$this->basket->getDeliveryMethod()){
			return $this->_redirect_to("set_payment_and_delivery_method");
		}

		$this->page_title = _("Doručovací údaje");

		$delivery_point = $this->basket->getDeliveryServiceBranch();
		$this->tpl_data["delivery_point_selected"] = $delivery_point_selected = !!$delivery_point;

		$delivery_countries_allowed = $this->basket->getDeliveryCountriesAllowed();

		if($this->logged_user && !$delivery_point_selected){
			$this->tpl_data["delivery_addresses"] = DeliveryAddress::GetInstancesByUser($this->logged_user,$delivery_countries_allowed);
		}

		$fill_in_invoice_address = ($this->request->get() && $this->basket->hasAddressSet()) || ($this->request->post() && $this->params->getString("fill_in_invoice_address")) || $delivery_point_selected;
		$this->tpl_data["fill_in_invoice_address"] = $fill_in_invoice_address;

		$initial = $this->basket->toArray();
		$initial = array_filter($initial,function($item){ return !is_null($item); });
		$this->form->set_initial($initial);
		# kdyz mame pro doruceni vybranou pobocku,
		# prebijeme dorucovaci adresu adresou pobocky
		# a predvyplnime fakturacni adresu udaji z nastaveni uzivatele
		if ($delivery_point_selected) {
			$this->form->set_initial($delivery_point->getDeliveryAddressAr());
			$this->logged_user && $this->form->set_initial([
				"firstname" => $this->logged_user->getFirstname(),
				"lastname" => $this->logged_user->getLastname(),
				"company" => $this->logged_user->getCompany(),
				"company_number" => $this->logged_user->getCompanyNumber(),
				"vat_id" => $this->logged_user->getVatId(),
				"address_street" => $this->logged_user->getAddressStreet(),
				"address_city" => $this->logged_user->getAddressCity(),
				"address_zip" => $this->logged_user->getAddressZip(),
				"address_state" => $this->logged_user->getAddressState(),
				"address_country" => $this->logged_user->getAddressCountry(),
			]);
			// fine-tuning of the delivery_company field
			$this->form->fields["delivery_company"]->required = true;
			$this->form->fields["delivery_company"]->label = _("Název doručovacího místa");
		}
		$this->form->set_initial("fill_in_invoice_address",$fill_in_invoice_address);

		// Policka fakturacni adresy jsou povinna pouze nekdy...
		$INVOICE_ADDRESS_FIELDS = Basket::GetAddressFields(["company_data" => true, "phone" => false, "address_street2" => false, "address_state" => ALLOW_STATE_IN_ADDRESS]);
		if($fill_in_invoice_address || $this->request->get()){
			foreach($INVOICE_ADDRESS_FIELDS as $k => $required){
				$this->form->fields["$k"]->required = $required;
			}
		}

		// Smazani udaju fakturacni adresy, pokud clovek nezatrhnul, ze ji chce vyplnovat
		$params = $this->params->toArray();
		if($this->request->post() && !$fill_in_invoice_address){
			foreach($INVOICE_ADDRESS_FIELDS as $k => $required){
				$params[$k] = null;
			}
		}

		if($this->request->post() && ($d = $this->form->validate($params))){
			$d["vat_id_valid_for_cross_border_transactions_within_eu"] = $d["vat_id"]->isValidForCrossBorderTransactionsWithinEu();

			if($delivery_point_selected){
				// dorucovaci adresu v tomto pripade nechceme do kosiku ukladat a
				// klidne tam nechame to, co tam je
				foreach(array_keys($delivery_point->getDeliveryAddressAr()) as $k){
					unset($d[$k]);
				}
			}

			$this->basket->s($d);
			$this->_redirect_to("summary");
		}
		$this->datalayer->push(new DatalayerGenerator\MessageGenerators\GA4\AddShippingInfo($this->basket, ["items" => $this->basket->getBasketItems()]));
		$this->datalayer->push(new DatalayerGenerator\MessageGenerators\GA4\AddPaymentInfo($this->basket, ["items" => $this->basket->getBasketItems()]));
	}

	function summary(){
		if(!$this->basket->getPaymentMethod() || !$this->basket->getDeliveryMethod()){
			return $this->_redirect_to("set_payment_and_delivery_method");
		}

		if(!$this->basket->hasDeliveryAddressSet()){
			return $this->_redirect_to("set_billing_and_delivery_data");
		}

		if(!$this->basket->canOrderBeCreated()){
			$this->flash->warning(_("Odstraňte prosím nedostatky, které brání dokončení objednávky"));
			return $this->_redirect_to("baskets/edit");
		}

		if($this->basket->getPriceToPay()<0.0){
			$this->flash->warning(_("Celková cena nesmí být záporná. Přihoďte do košíku ještě něco! :)"));
			return $this->_redirect_to("baskets/edit");
		}

		$this->page_title = _("Rekapitulace objednávky");

		$this->form->set_initial("note",$this->basket->getNote());
		$this->form->set_hidden_field("checksum",$this->basket->getChecksum());

		if($this->request->post() && !is_null($d = $this->form->validate($this->params))){
			if($this->basket->getChecksum()!==$this->params->getString("checksum")){
				$this->form->set_error(_("Změnil se obsah nákupního košíku. Prohlédněte si rekapitulaci ještě jednou a dokončete objednávku."));
				return;
			}

			// V tomto kroku lze jeste zadat poznamku k objednavce
			$this->basket->s("note",$d["note"]);

			$order = $this->basket->createOrder([
				"send_notification" => true,
				"mailer" => $this->mailer,
			]);
			// Vytvoreni objednavky uz neni notifikovano tady.
			// Je na to spec. robot. V emailu se totiz posila PDF s prehledem obj. zbozi a jeho vytvoreni muze trvat dlouho.
			//$this->mailer->notify_order_creation($order);
			$this->basket->destroy();

			if($d["sign_up_for_newsletter"]){
				NewsletterSubscriber::SignUp($order->getEmail(),array(
					"name" => trim($order->getFirstname()." ".$order->getLastname()),
				));
			}

			// Yarri: toto je asi trackovani objednavek v Google Analytics
			$this->session->s("track_order", true);

			// ulozime pouzitou dorucovaci adresu do dorucovacich adres
			if($da = DeliveryAddress::GetOrCreateRecordByOrder($order)){
				$da->s([
					"last_used_at" => now(),
					"updated_at" => $da->g("updated_at"),
				]);
			}

			$this->_redirect_to([
				"action" => "finish",
				"token" => $order->getToken(),
			]);
		}
	}

	function finish(){
		if(!$order = Order::GetInstanceByToken($this->params->getString("token"))){
			$this->_execute_action("error404");
			return;
		}

		$this->_redirect_to([
			"action" => "orders/finish",
			"token" => $order->getToken(),
		]);
	}

	function _before_filter(){
		$this->basket = $this->_get_basket();
		if($this->basket->isEmpty() && $this->action!="finish"){
			return $this->_redirect_to("baskets/edit");
		}

		$this->breadcrumbs[] = _("Nákupní košík");
	}

	function _before_render(){
		parent::_before_render();
		$this->_prepare_checkout_navigation();
	}
}
