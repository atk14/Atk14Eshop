<?php
namespace PaymentGatewayApi;

definedef("TESTING_PAYMENT_GATEWAY_API_KEY",""); // e.g. "123.abcdef..."
definedef("TESTING_PAYMENT_GATEWAY_API_URL","http://test-payment-gateway.localhost/api/");

class TestingPaymentGateway extends PaymentGatewayApi {

	function prepareForOrder($order){
	}

	function isProperlyConfigured(){
	}

	function testingApi(){
		return true;
	}

	function _getStartTransactionUrl(&$payment_transaction,&$transaction_id){
		$order = $payment_transaction->getOrder();

		$region = $order->getRegion();
		$currency = $payment_transaction->getCurrency();

		$params = [
			"price" => $payment_transaction->getPriceToPay(),
			"currency" => (string)$currency, // "CZK", "EUR"
			"language" => $order->getLanguage(),
			"api_key" => TESTING_PAYMENT_GATEWAY_API_KEY,

			"order_no" => $order->getOrderNo(),
			"eshop_name" => $region->getApplicationName(),

			"return_url" => Atk14Url::BuildLink(["namespace" => "", "controller" => "test_payment_gateway", "action" => "finish_transaction"]),
		];
	}
}
