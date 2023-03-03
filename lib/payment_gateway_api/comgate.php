<?php
namespace PaymentGatewayApi;

definedef("COMGATE_TESTING",false); // true (testing gateway), false
definedef("COMGATE_MERCHANT_ID",""); // "123456"
definedef("COMGATE_MERCHANT",""); // "www.example.com test"
definedef("COMGATE_SECRET",""); // "kdo3DSKEOFerlpocewfdkoerjpgfpojregj"
definedef("COMGATE_BASE_URL","https://payments.comgate.cz/v1.0/");

class Comgate extends PaymentGatewayApi {


	static function IsProperlyConfigured(){
		foreach(["COMGATE_MERCHANT_ID","COMGATE_MERCHANT","COMGATE_SECRET","COMGATE_BASE_URL"] as $c_name){
			if(!strlen(constant($c_name))){ return false; }
		}
		return true;
	}

	function testingApi(){
		return COMGATE_TESTING;
	}

	function getMethods(){
		return $this->_doRequest("post","methods",[
			"merchant" => COMGATE_MERCHANT_ID,
			"secret" => COMGATE_SECRET,
			"type" => "json",
			"lang" => "cs",
		]);
	}

	function _getStartTransactionUrl(&$payment_transaction,&$transaction_id){
		$order = $payment_transaction->getOrder();

		$region = $order->getRegion();
		$currency = $payment_transaction->getCurrency();

		$params = [
			"price" => $payment_transaction->getPriceToPay() * 100.0,
			"curr" => (string)$currency, // "CZK", "EUR"
			"label" => sprintf(_("Objednávka č. %s na %s"),$order->getOrderNo(),$region->getApplicationName()),
			//"refId" => $order->getOrderNo(), // Toto ne, ....
			"refId" => $payment_transaction->getId(), // ... toto je asi jistejsi volba
			"payerName" => trim($order->getFirstname()." ".$order->getLastname()),
			"method" => "ALL",
			"email" => $order->getEmail(),
			"phone" => $order->getPhone() ? $order->getPhone() : $order->getPhoneMobile(),
			"lang" => $order->getLanguage(),
			"country" => $order->getDeliveryAddressCountry() ? $order->getDeliveryAddressCountry() : $order->getAddressCountry(), // Tady davame zamerne zemi doruceni!
			"prepareOnly" => "true",
			"test" => COMGATE_TESTING ? "true" : "false",
		];

		$params += [
			"merchant" => COMGATE_MERCHANT_ID,
			"secret" => COMGATE_SECRET,
			"type" => "json",
		];

		$data = $this->post("create",$params);

		// Tady je chyba pri platbe EURem:
		// "code": "1308"
		// "message": "No payment method is enabled for you in CZ country and EUR currency! Only following countries, methods and currencies are enabled for you: CZ:BANK_CZ_AB:CZK, CZ:BANK_CZ_CSOB_P:CZK, CZ:BANK_CZ_CS_P:CZK, CZ:BANK_CZ_CTB:CZK, CZ:BANK_CZ_EB:CZK, CZ:BANK_CZ_FB:CZK, CZ:BANK_CZ_GE:CZK, CZ:BANK_CZ_KB:CZK, CZ:BANK_CZ_MB_P:CZK, CZ:BANK_CZ_OTHER:CZK, CZ:BANK_CZ_PS_P:CZK, CZ:BANK_CZ_RB:CZK, CZ:BANK_CZ_UC:CZK, CZ:BANK_CZ_VB:CZK, CZ:BANK_CZ_ZB:CZK"

		$_assert_msg = "$data[code] / $data[message]";

		myAssert($data["code"]==="0",$_assert_msg);
		myAssert(strlen($data["transId"]),$_assert_msg);
		myAssert(strlen($data["redirect"]),$_assert_msg);

		$transaction_id = $data["transId"];
		return $data["redirect"];

		$payment_transaction->s([
			"payment_transaction_started_at" => now(),
			"payment_transaction_started_from_addr" => $this->request->getRemoteAddr(),
			"payment_transaction_id" => $data["transId"],
			"payment_transaction_url" => $data["redirect"],
			"testing_payment" => COMGATE_TESTING,
		]);
	}


	protected function _getCurrentPaymentStatusCode(&$payment_transaction){
		$trans_id = $payment_transaction->getPaymentTransactionId(); // "FJLA-EASH-QVZS"
		myAssert(strlen($trans_id)>0);

		$data = $this->_getStatus($payment_transaction);
		myAssert($data["code"]==="0");
		myAssert($data["message"]==="OK");
		myAssert($data["transId"]===$trans_id);

		$status = $data["status"];
		myAssert(strlen($status)>0);

		$tr = [
			"PAID" => "paid",
			"CANCELLED" => "cancelled",
			"PENDING" => "pending",
		];
		myAssert(isset($tr[$status]),"unknown status: $status");

		$code = $tr[$status];

		return $code;
	}

	function _getStatus($payment_transaction){
		$trans_id = $payment_transaction->getPaymentTransactionId();
		return $this->get("status",[
			"transId" => $trans_id,
			"merchant" => COMGATE_MERCHANT_ID,
			"secret" => COMGATE_SECRET,
			"type" => "json",
		]);
	}

	function get($command,$params = []){
		return $this->_doRequest("get",$command,$params);
	}

	function post($command,$params = []){
		return $this->_doRequest("post",$command,$params);
	}
	
	function _doRequest($method,$command,$params){
		$url = COMGATE_BASE_URL.$command;
		if($method=="get"){
			$url .= $params ? "?".http_build_query($params) : "";
		}

		$uf = new \UrlFetcher($url);

		if($method=="post"){
			$uf->$method($params);
		}

		$status_code = $uf->getStatusCode();
		if(!preg_match('/^2\d\d$/',$status_code)){
			// TODO: Zalogovat chybu
			throw new \Exception(sprintf("%s: Invalid status code (%s) on %s %s",get_class($this),$status_code,$method,$url));
		}

		$data = $uf->getContent();

		$real_url = $uf->getUrl();
		if(preg_match('/error\/error/',$real_url)){
			// doslo k presmerovani na:
			// https://payments.comgate.cz/error/error/
			return null;
		}
		
		$_data = json_decode($data,true);

		if(is_array($_data)){
			$data = $_data;
		}elseif($uf->getContentType()=="application/x-www-form-urlencoded"){
			$_data = [];
			if(strlen($data)){ // "code=1308&message=Production+environment+is+not+enabled+for+you%2C+it+is+enabled+testing+environment+only"
				parse_str($data,$_data);
			}
			$data = $_data;
		}

		return $data;
	}
}
