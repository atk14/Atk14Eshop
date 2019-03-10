<?php
class BasketsController extends ApplicationController {

	function edit(){
		$basket = $this->_get_basket();
		$this->_prepare_basket_edit_form($basket,$this->form);

		$this->tpl_data["can_order_be_created"] = $basket->canOrderBeCreated($error_messages);
		$this->tpl_data["error_messages"] = $error_messages;

		if($this->session->g("voucher_initial")){
			$this->form->set_initial("voucher",$this->session->g("voucher_initial"));
			$this->session->clear("voucher_initial");
		}

		if($this->request->post()){
			// Chyby z formulare neukazujeme, tak aktualizaci kosiku resime takto:

			$return_anchor = "";

			if($d = $this->form->validate($this->params)){
				foreach($basket->getItems() as $item){
					$id = $item->getId();
					$req_amount = $d["i$id"];
					if($req_amount!=$item->getAmount()){
						$item->s("amount",$req_amount);
					}
				}

				if($d["voucher"]){
					$return_anchor = "vouchers";

					$voucher = Voucher::FindByVoucherCode(Translate::Upper($d["voucher"]));
					if(!$voucher){
						$this->session->s("voucher_initial",$d["voucher"]);
						$this->flash->warning(_("Takový slevový kupón neexistuje"));
					}elseif(!$voucher->isApplicable($basket,$err_msg)){
						$this->session->s("voucher_initial",$d["voucher"]);
						$this->flash->warning($err_msg);
					}else{
						$lister = $basket->getVouchersLister();
						if(!$lister->contains($voucher)){
							$lister->add($voucher);
							$this->flash->success(_("Slevový kupón byl přidán"));
						}
					}
				}
			}

			if($this->params->defined("continue")){
				// Bylo stisknuto tlacitko pokracovat

				// K teto kontrole dochazi az v CheckoutsController
				//if(!$this->basket->canOrderBeCreated()){
				//	$this->_redirect_to("edit");
				//	return;
				//}

				$this->_redirect_to("checkouts/set_payment_and_delivery_method");
				return;
			}

			$this->_redirect_to($this->_link_to("edit").($return_anchor ? "#$return_anchor" : ""));
			return;
		}

		if(!$basket || $basket->isEmpty()){
			$this->_execute_action("empty_basket");
			return;
		}

		$this->page_title = $this->breadcrumbs[] = _("Nákupní košík");


		$this->_prepare_checkout_navigation();
	}

	function empty_basket(){
		$basket = $this->_get_basket();
		if(!$basket->isEmpty()){
			return $this->_redirect_to("edit");
		}
		$this->page_title = $this->breadcrumbs[] = _("Shopping basket");
	}

	function add_product(){
		$product = $this->product;
		if(!$this->request->post()){
			return $this->_execute_action("error404");
		}

		// Pocet ($amount) zvalidujeme pres formularove policko, to je mazane a nenecha se osalit
		$this->form->add_field("amount", new OrderQuantityField($product));
		$amount = $this->params->getInt("amount") ? $this->params->getInt("amount") : $this->form->fields["amount"]->initial;
		if(!$d = $this->form->validate(["amount" => $amount])){
			// ... je tu nejaky spatny pocet
			return $this->_execute_action("error404");
		}
		$amount = $d["amount"];

		$basket = $this->_get_basket(true);
		if(!$basket){
			return;
		}

		if(!$product->canBeOrdered(["region" => $this->current_region, "amount" => $amount, "price_finder" => $this->price_finder])){
			return $this->_execute_action("error404");
		}

		$basket->addProduct($product,$amount);

		if($this->request->xhr()){
			// Pro XHR request je tady normalne pripravena sablona
			$this->response->setContentType("text/json");
			return;
		}

		$this->_redirect_to([
			"action" => "baskets/product_added",
			"product_id" => $product,
		]);
	}

	function product_added(){
		$this->breadcrumbs[] = [_("Shopping basket"),"index"];
		$this->page_title = $this->breadcrumbs[] = _("Produkt byl přidán do košíku");
	}

	function _before_filter(){
		if(in_array($this->action,["add_product","product_added"])){
			if(!($this->product = $this->tpl_data["product"] = $this->_just_find_product())){
				return $this->_execute_action("error404");
			}
		}
	}

	function _just_find_product(){
		$product = $this->_just_find("product","product_id");
		if(!$product || !$product->isVisible() || $product->isDeleted()){
			return null;
		}

		// kontrola existence ceny
		if(!$this->price_finder->getPrice($product)){
			return null;
		}

		return $product;
	}
}
