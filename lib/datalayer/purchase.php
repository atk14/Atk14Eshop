<?php
class Purchase extends DatalayerGenerator\MessageGenerators\Purchase implements DatalayerGenerator\MessageGenerators\iMessage {

	function getDatalayerMessage() {
		$order = $this->getObject();
		$out = parent::getDatalayerMessage();
		$out["ecommerce"]["currencyCode"] = $order->getCurrency()->toString();
		return $out;
	}

	/**
	 * to be removed
	 */
	function getObject() {
		return $this->object;
	}

	function getActivityData() {
		$order = $this->getObject();
		$order_items = $order->getOrderItems();
		$out = [];
		foreach($order_items as $_o) {
			$product = $_o->getProduct();
			$objDT = \DatalayerGenerator\Datatypes\EcDatatype::CreateProduct($product, $this->options);
			$_p = $objDT->getData();
			$_p["price"] = (float)number_format($_o->getUnitPriceInclVat(), 2, ".", "");
			$_p["price"] = number_format($_o->getUnitPriceInclVat(), 0, ".", "");
			$_p["quantity"] = $_o->getAmount();
			$out[] = $_p;
		}

		$out = [ "products" => $out ];
		return $out;
	}

	function getActionField() {
		$order = $this->getObject();

		$price = $this->_getPriceToPay($order,false);
		$price_vat = $this->_getPriceToPay($order,true);
		$vat = $price_vat - $price;
		$currency = $order->getCurrency();;
		return [
			"id" => $order->getOrderNo(),
			"affiliation" => ATK14_APPLICATION_NAME,
			"revenue" => round($price_vat, $currency->getDecimalsSummary()),
			"tax" => round($vat, $currency->getDecimalsSummary()),
			"shipping" => $order->getPaymentFeeInclVat() + $order->getDeliveryFeeInclVat(),
		];
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

}

