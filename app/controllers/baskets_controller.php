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
					$item->setAmount($req_amount);
				}

				if($d["voucher"]){
					$return_anchor = "vouchers";

					$voucher = Voucher::FindByVoucherCode(Translate::Upper($d["voucher"]));
					if(!$voucher){
						$this->session->s("voucher_initial",$d["voucher"]);
						$this->flash->error(_("Takový slevový kupón neexistuje"));
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

			if($this->request->xhr() && !$this->basket->isEmpty() && $this->form->is_valid()){
				// there is a template for the basket re-drawing using JS
				$this->_prepare_basket_edit_form($basket,$this->form);
				return;
			}

			$this->_redirect_to($this->_link_to("edit").($return_anchor ? "#$return_anchor" : ""));
			return;
		}

		if(!$basket || $basket->isEmpty()){
			$this->_execute_action("empty_basket");
			return;
		}

		$this->page_title = $this->breadcrumbs[] = _("Shopping basket");

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
		$this->_add_product();
	}

	function set_product_amount(){
		$this->_add_product(["rewrite_amount" => true]);
	}

	function product_added(){
		$this->breadcrumbs[] = [_("Shopping basket"),"baskets/edit"];
		$this->page_title = $this->breadcrumbs[] = _("Produkt byl přidán do košíku");
	}

	function _add_product($options = []){
		$options += [
			"rewrite_amount" => false,
		];
		$rewrite_amount = $options["rewrite_amount"];

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
			return $this->_execute_action("error404");
		}

		if(!$product->canBeOrdered(["region" => $this->current_region, "amount" => $amount, "price_finder" => $this->price_finder])){
			return $this->_execute_action("error404");
		}

		$original_amount = $basket->getProductAmount($product);
		$basket->addProduct($product,$amount,["rewrite_amount" => $rewrite_amount]);
		$current_amount = $basket->getProductAmount($product);

		if(!$this->request->xhr()){
			$this->_redirect_to([
				"action" => "baskets/product_added",
				"product_id" => $product,
			]);
			return;
		}

		$this->tpl_data["amount"] = $amount;
		$this->tpl_data["original_amount"] = $original_amount;
		$this->tpl_data["current_amount"] = $current_amount;

		// there are templates for XHR requests...
	}

	function _before_filter(){
		if(in_array($this->action,["add_product","set_product_amount","product_added"])){
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
