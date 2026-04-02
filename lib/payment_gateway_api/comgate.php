<?php
namespace PaymentGatewayApi;

definedef("COMGATE_TESTING",false); // true (testing gateway), false
definedef("COMGATE_MERCHANT_ID",""); // "123456"
definedef("COMGATE_SECRET",""); // "kdo3DSKEOFerlpocewfdkoerjpgfpojregj"
definedef("COMGATE_BASE_URL","https://payments.comgate.cz/v1.0/");
definedef("COMGATE_PROXY",""); // e.g. "tcp://192.168.1.1:8118"
definedef("COMGATE_PAYMENT_METHOD","ALL"); // "ALL", "CARD_ALL", "BANK_ALL"

class Comgate extends PaymentGatewayApi {

	protected $COMGATE_TESTING;
	protected $COMGATE_MERCHANT_ID;
	protected $COMGATE_SECRET;
	protected $COMGATE_BASE_URL;
	protected $COMGATE_PROXY;

	protected $http_host;

	protected $payment_method;

	function __construct($options = []){

		$this->COMGATE_TESTING = COMGATE_TESTING;
		$this->COMGATE_MERCHANT_ID = COMGATE_MERCHANT_ID;
		$this->COMGATE_SECRET = COMGATE_SECRET;
		$this->COMGATE_BASE_URL = COMGATE_BASE_URL;
		$this->COMGATE_PROXY = COMGATE_PROXY;

		$this->http_host = ATK14_HTTP_HOST;
		$this->payment_method = COMGATE_PAYMENT_METHOD;

		parent::__construct($options);
	}

	function prepareForOrder($order){

	}

	function isProperlyConfigured(){
		foreach(["COMGATE_MERCHANT_ID","COMGATE_SECRET","COMGATE_BASE_URL"] as $c_name){
			if(!strlen($this->$c_name)){ return false; }
		}
		return true;
	}

	function testingApi(){
		return $this->COMGATE_TESTING;
	}

	function getMethods(){
		return $this->_doRequest("post","methods",[
			"merchant" => $this->COMGATE_MERCHANT_ID,
			"secret" => $this->COMGATE_SECRET,
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
			"fullName" => trim($order->getFirstname()." ".$order->getLastname()),
			"method" => $this->payment_method,
			"email" => $order->getEmail(),
			"phone" => $order->getPhone(),
			"lang" => $order->getLanguage(),
			"country" => $order->getDeliveryAddressCountry() ? $order->getDeliveryAddressCountry() : $order->getAddressCountry(), // Tady davame zamerne zemi doruceni!
			"prepareOnly" => "true",
			"test" => $this->COMGATE_TESTING ? "true" : "false",
		];

		$params += [
			"merchant" => $this->COMGATE_MERCHANT_ID,
			"secret" => $this->COMGATE_SECRET,
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
	}


	protected function _getCurrentPaymentStatusCode(&$payment_transaction,&$data = null,&$internal_status = null){
		$trans_id = $payment_transaction->getPaymentTransactionId(); // "FJLA-EASH-QVZS"
		myAssert(strlen($trans_id)>0);

		$data = $this->_getStatus($payment_transaction);
		myAssert($data["code"]==="0","'$data[code]' is not '0' (data: ".trim(print_r($data,true)).")");
		myAssert($data["message"]==="OK");
		myAssert($data["transId"]===$trans_id);

		$status = $data["status"];
		myAssert(strlen($status)>0);

		$internal_status = $status;

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
			"merchant" => $this->COMGATE_MERCHANT_ID,
			"secret" => $this->COMGATE_SECRET,
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
		$url = $this->COMGATE_BASE_URL.$command;
		if($method=="get"){
			$url .= $params ? "?".http_build_query($params) : "";
		}

		$uf = new \UrlFetcher($url,["proxy" => $this->COMGATE_PROXY]);

		if($method=="post"){
			$uf->$method($params);
		}

		$status_code = $uf->getStatusCode();
		if(!preg_match('/^2\d\d$/',$status_code)){
			throw new \Exception($this->_compileUrlFetcherErrorMessage($uf));
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

		if(is_array($data) && isset($data["secret"])){
			$data["secret"] = "undisclosed";
		}

		return $data;
	}
}
