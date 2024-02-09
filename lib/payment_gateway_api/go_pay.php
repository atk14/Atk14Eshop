<?php
namespace PaymentGatewayApi;

definedef("GO_PAY_TESTING",false);
definedef("GO_PAY_CLIENT_ID","");
definedef("GO_PAY_CLIENT_SECRET","");
definedef("GO_PAY_GOID","");

class GoPay extends PaymentGatewayApi {

	function prepareForOrder($order){
	}
	
	function isProperlyConfigured(){
		foreach(["GO_PAY_CLIENT_ID","GO_PAY_CLIENT_SECRET","GO_PAY_GOID"] as $c_name){
			if(!strlen(constant($c_name))){ return false; }
		}
		return true;
	}

	function testingApi(){
		return GO_PAY_TESTING;
	}

	function _getStartTransactionUrl(&$payment_transaction,&$transaction_id){
		$api = $this->_getApi();

		$order = $payment_transaction->getOrder();
		
		$params = [
			"target" => [
				"type" => "ACCOUNT",
				"goid" => GO_PAY_GOID,
			],
			"payer" => [
				"email" => $order->getEmail(),
			],
			"amount" => $payment_transaction->getPriceToPay() * 100.0, // it is in cents
			"currency" => $order->getCurrency()->getCode(), // "CZK"
			"order_number" => $order->getOrderNo(),
			"lang" => strtoupper($order->getLanguage()), // "CS"
			"callback" => [
				"return_url" => \Atk14Url::BuildLink(["namespace" => "", "controller" => "go_pay", "action" => "finish_transaction"],["with_hostname" => true]),
				"notification_url" => \Atk14Url::BuildLink(["namespace" => "", "controller" => "go_pay", "action" => "update_status"],["with_hostname" => true]),
			],
		];

		$json = json_encode($params);

		$data = $api->postRawData("payments/payment",$json,[],["mime_type" => "application/json"]);
		myAssert(isset($data["id"]) && is_numeric($data["id"]),"data does not contain numeric id: ".print_r($data,true));
		myAssert(isset($data["gw_url"]) && is_string($data["gw_url"]),"data does not contain gw_url: ".print_r($data,true));

		$transaction_id = $data["id"];
		return $data["gw_url"];
	}

	protected function _getCurrentPaymentStatusCode(&$payment_transaction,&$data = null,&$internal_status = null){
		$transaction_id = $payment_transaction->getPaymentTransactionId(); // "123456"
		myAssert(strlen($transaction_id)>0);

		$tr = [
			"CREATED" => "pending", //Platba vytvořena
			"PAID" => "paid", //Platba uhrazena
			"CANCELED" => "cancelled", //Platba zamítnuta
			"PAYMENT_METHOD_CHOSEN" => "pending", //Platební metoda potvrzena
			"TIMEOUTED" => "cancelled", //Platbě vypršela životnost
			"AUTHORIZED" => "pending", //Platba předautorizována
			"REFUNDED" => "cancelled", //Platba vrácena
			"PARTIALLY_REFUNDED" => "cancelled", //Platba částečně vrácena
		];

		$api = $this->_getApi();

		$data = $api->get("payments/payment/$transaction_id");

		myAssert(isset($data["state"]) && is_string($data["state"]),"there is no stringy value state in the data: ".print_r($data,true));
		$order_no = $payment_transaction->getOrder()->getOrderNo();
		myAssert($data["order_number"]===$order_no,"order_number is not $order_no: ".print_r($data,true));

		$status = $data["state"];
		myAssert(isset($tr[$status]),"unknown internal status $status");

		$internal_status = $status;

		$code = $tr[$status];

		return $code;
	}

	function _getApi(){
		$api_url = $this->testingApi() ? "https://gw.sandbox.gopay.com/api/" : "https://gate.gopay.cz/api/";
		$options = ["lang" => "","default_params" => [], "automatically_add_trailing_slash" => false, "additional_headers" => ["Accept: application/json"]];

		$adf = new \ApiDataFetcher($api_url,$options);
		$access_token = $this->_getAccessToken($adf);

		$options["additional_headers"][] = "Authorization: Bearer $access_token";
		$adf = new \ApiDataFetcher($api_url,$options);

		return $adf;
	}

	function _getAccessToken($api){
		static $access_token;

		if(!$access_token){
			$data = $api->post("oauth2/token",[
				"scope" => "payment-create",
				"grant_type" => "client_credentials",
			],[
				"additional_headers" => ["Authorization: Basic ".base64_encode(GO_PAY_CLIENT_ID.":".GO_PAY_CLIENT_SECRET)],
			]);

			myAssert(strlen($data["access_token"])>0);
			$access_token = $data["access_token"];
		}

		return $access_token;
	}
}
