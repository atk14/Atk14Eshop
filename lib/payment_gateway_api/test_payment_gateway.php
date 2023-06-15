<?php
namespace PaymentGatewayApi;

// A usable key is 10.atk14eshop.kbjQB83v9ylSV4L7D0cmgKfEGrNuie5o:
definedef("TEST_PAYMENT_GATEWAY_API_KEY","");
definedef("TEST_PAYMENT_GATEWAY_API_URL","https://test-payment-gateway.gibona.com/api/");

class TestPaymentGateway extends PaymentGatewayApi {

	function prepareForOrder($order){
	}

	function isProperlyConfigured(){
		foreach(["TEST_PAYMENT_GATEWAY_API_KEY","TEST_PAYMENT_GATEWAY_API_KEY"] as $c_name){
			if(!strlen((string)constant($c_name))){ return false; }
		}
		return true;
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
			"api_key" => TEST_PAYMENT_GATEWAY_API_KEY,

			"order_no" => $order->getOrderNo(),
			"eshop_name" => $region->getApplicationName(),

			"return_url" => \Atk14Url::BuildLink(["namespace" => "", "controller" => "test_payment_gateway", "action" => "finish_transaction"],["with_hostname" => true]),
		];

		$adf = new \ApiDataFetcher(TEST_PAYMENT_GATEWAY_API_URL,["lang" => "en"]);
		$data = $adf->post("payment_transactions/create_new",$params);

		myAssert(strlen($data["transaction_id"])>0);
		myAssert(strlen($data["url"])>0);

		$transaction_id = $data["transaction_id"];
		return $data["url"];
	}

	protected function _getCurrentPaymentStatusCode(&$payment_transaction,&$data = null,&$internal_status = null){
		$transaction_id = $payment_transaction->getPaymentTransactionId(); // "RREG-EFRV-TAGA"
		myAssert(strlen($transaction_id)>0);

		$params = [
			"api_key" => TEST_PAYMENT_GATEWAY_API_KEY,
			"transaction_id" => $transaction_id,
		];

		$adf = new \ApiDataFetcher(TEST_PAYMENT_GATEWAY_API_URL,["lang" => "en"]);
		$data = $adf->get("payment_transactions/detail",$params,["acceptable_error_codes" => [404]]);

		if($adf->getStatusCode()==404){
			// There is no such transaction
			$data = null;
			return;
		}

		$status = $data["payment_status"];
		myAssert(strlen($status)>0);

		myAssert((string)$data["order_no"]===(string)$payment_transaction->getOrder()->getOrderNo());

		$internal_status = $status;

		$tr = [
			"paid" => "paid",
			"cancelled" => "cancelled",
			"pending" => "pending",
		];
		myAssert(isset($tr[$status]),"unknown status: $status");

		$code = $tr[$status];

		return $code;
	}
}
