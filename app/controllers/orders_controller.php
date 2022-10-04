<?php
class OrdersController extends ApplicationController {

	function index() {
		$this->page_title = $this->breadcrumbs[] = _("Archiv objednávek");
		$this->tpl_data["orders"] = Order::FindAllByUserId($this->logged_user, array("order_by" => "created_at DESC"));
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
	}

	function finish(){
		$this->_prepare_checkout_navigation();

		$this->page_title = _("Objednávka byla dokončena");

		// Objednavka tady byt muze, ale taky nemusi...
		$this->tpl_data["order"] = $order = Order::GetInstanceByToken($this->params->getString("token"));
		if($order && $order->getOrderStatus()->getCode()==="waiting_for_online_payment"){
			$this->tpl_data["payment_transaction_start_url"] = $order->getPaymentTransactionStartUrl();
		}
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
