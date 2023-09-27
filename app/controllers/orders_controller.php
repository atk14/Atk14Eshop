<?php
class OrdersController extends ApplicationController {

	function index() {
		$this->page_title = $this->breadcrumbs[] = _("Archiv objednávek");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = [];
		
		$conditions[] = "user_id=:user";
		$bind_ar[":user"] = $this->logged_user;

		if($d["search"]){
			$_fields = array();
			$_fields[] = "order_no";
			$_fields[] = "COALESCE((SELECT STRING_AGG(body, ' ') FROM translations t, order_items oi WHERE oi.order_id=orders.id AND t.table_name='products' AND t.key IN ('label','name') AND t.record_id=oi.product_id),'')";
			$_fields[] = "COALESCE((SELECT STRING_AGG(catalog_id, ' ') FROM products p, order_items oi WHERE oi.order_id=orders.id AND p.id=oi.product_id),'')";
			$_fields[] = "COALESCE((SELECT STRING_AGG(body, ' ') FROM translations t, order_items oi, products p WHERE oi.order_id=orders.id AND p.id=oi.product_id AND t.table_name='cards' AND t.key IN ('name') AND t.record_id=p.card_id),'')";

			if($ft_cond = FullTextSearchQueryLike::GetQuery("UPPER(".join("||' '||",$_fields).")",Translate::Upper($d["search"]),$bind_ar)){
				$conditions[] = $ft_cond;
			}
		}

		$this->sorting->add("created_at","created_at DESC, id DESC");

		$this->tpl_data["orders_total"] = $this->dbmole->selectInt("SELECT COUNT(*) FROM orders WHERE user_id=:user",[":user" => $this->logged_user]);
		$this->tpl_data["finder"] = Order::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => $this->sorting,
			"offset" => $this->params->getInt("offset")
		]);
	}

	function detail(){
		if(!$order = $this->_find_order()){
			return $this->_execute_action("error404");
		}

		$this->tpl_data["order"] = $order;

		$this->_add_order_to_breadcrumbs($order);

		$this->page_title = sprintf(_("Objednávka %s"),$order->getOrderNo());

		$spec_key = TechnicalSpecificationKey::FindByCode("care_instructions");
		$this->tpl_data["contains_product_with_care_instructions"] = $this->dbmole->selectInt("
			SELECT COUNT(*) FROM technical_specifications WHERE
				technical_specification_key_id=:spec_key AND
				card_id IN (SELECT card_id FROM products WHERE id IN (SELECT product_id FROM order_items WHERE order_id=:order))
		",[
			":spec_key" => $spec_key,
			":order" => $order,
		]);
		$this->head_tags->setMetaTag("robots", "noindex,noarchive");
		$this->head_tags->setMetaTag("googlebot", "noindex");
	}

	function finish(){
		$this->_prepare_checkout_navigation();

		$this->page_title = _("Objednávka byla dokončena");

		// The order object can not be set
		$order = null;
		if($this->params->defined("token")){
			$order = Order::GetInstanceByToken($this->params->getString("token"));
			if(!$order){
				$this->_execute_action("error404");
				return;
			}
			$allowed_order_statuses = [
				"new",
				"waiting_for_bank_transfer",
				"repeated_payment_request",
				"waiting_for_online_payment",
				"payment_accepted",
				"payment_failed",
			];
			// For other statuses, we do not want to disclose any information about the order
			if(!in_array($order->getOrderStatus()->getCode(),$allowed_order_statuses)){
				$order = null;	
			}
		}

		$this->tpl_data["order"] = $order;
		$this->tpl_data["payment_transaction"] = $order ? $order->getPaymentTransaction() : null;

		$this->_collectTransactionDataLayer($order);
	}

	private function _collectTransactionDataLayer($order) {
		if (is_null($order)) {
			return;
		}
		if ($this->session->defined("track_order") && ($this->session->g("track_order")===true)) {
			$this->tpl_data["track_order"] = true;
			$currency = $order->getCurrency();
			$pAr = array();
			foreach($order->getOrderItems() as $oi) {
				$p = $oi->getProduct();
				$unit = $p->getUnit();
				$amount = $oi->getAmount();
				$unit_price_incl_vat = $oi->getUnitPriceInclVat();
				$pAr[] = array(
					"id" => $p->getId(),
					"name" => $p->getName(),
					"sku" => $p->getCatalogId(),
					"price" => round($unit_price_incl_vat, $currency->getDecimals()),
					"quantity" => $amount,
				);
			}
			$price = $this->_getPriceToPay($order,false);
			$price_vat = $this->_getPriceToPay($order,true);
			$vat = $price_vat - $price;
			$dataLayer = array(
				"transactionId" => $order->getOrderNo(),
				"transactionTotal" => round($price_vat, $currency->getDecimalsSummary()),
				"transactionTax" => round($vat, $currency->getDecimalsSummary()),
				"transactionShipping" => $order->getPaymentFeeInclVat() + $order->getDeliveryFeeInclVat(),
				"transactionCurrency" => $order->getCurrency()->toString(),
				"transactionProducts" => $pAr,
			);
			$this->tpl_data["dataLayer"] = $dataLayer;
		}
		$this->session->clear("track_order");
	}

	/**
	 * Celkova cena za transakci:
	 * + cena za zbozi
	 * - sleva za vouchery
	 * - sleva za kampane (registrace, velka objednavka ...
	 */
	private function _getPriceToPay($order, $incl_vat=true) {
		$_price = $order->getItemsPrice($incl_vat);
		$_price -= $order->getVouchersDiscountAmount($incl_vat);
		$_price -= $order->getCampaignsDiscountAmount($incl_vat);
		return $_price;
	}

	function _before_filter(){
		if($this->action==="finish"){
			$this->breadcrumbs[] = _("Shopping basket");
		}else{
			$this->_add_user_detail_breadcrumb();
		}
	}

	function _logged_user_required(){
		if(in_array($this->action,["detail","care_instructions","finish"])){
			return false;
		}
		return true;
	}
}
