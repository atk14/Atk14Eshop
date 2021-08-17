<?php
namespace PaymentGatewayApi;

// Testovaci karta pro testovaci prostredi: 4056070000000008, Expiry: 12/2020, CVC2: 200

defined("GP_WEBPAY_MERCHANT_NUMBER") || define("GP_WEBPAY_MERCHANT_NUMBER","9661234567");
defined("GP_WEBPAY_PROVIDER_CODE") || define("GP_WEBPAY_PROVIDER_CODE","0100"); // Kód poskytovatele, 0100 -> Komercni banka
defined("GP_WEBPAY_URL") || define("GP_WEBPAY_URL","https://test.3dsecure.gpwebpay.com/pgw/order.do"); // testing: https://test.3dsecure.gpwebpay.com/pgw/order.do; production: https://3dsecure.gpwebpay.com/pgw/order.do
defined("GP_WEBPAY_WS_URL") || define("GP_WEBPAY_WS_URL","https://test.3dsecure.gpwebpay.com/pay-ws/v1/PaymentService"); // testing: https://test.3dsecure.gpwebpay.com/pay-ws/v1/PaymentService; production: https://3dsecure.gpwebpay.com/pay-ws/v1/PaymentService
//define("GP_WEBPAY_WS_URL","https://3dsecure.gpwebpay.com/pay-ws/v1/PaymentService"); // testing: https://test.3dsecure.gpwebpay.com/pay-ws/v1/PaymentService; production: https://3dsecure.gpwebpay.com/pay-ws/v1/PaymentService
//define("GP_WEBPAY_PRIVATE_KEY",__DIR__ . "/../../doc/platebni_brany/GPWebPay/gpwebpay-pvk.key");

defined("GP_WEBPAY_PRIVATE_KEY") || define("GP_WEBPAY_PRIVATE_KEY",__DIR__ . "/../../config/gpwebpay-pvk.test.key");
defined("GP_WEBPAY_PRIVATE_KEY_PASSWORD") || define("GP_WEBPAY_PRIVATE_KEY_PASSWORD","secret");

defined("GP_WEBPAY_TESTING") || define("GP_WEBPAY_TESTING",true);

class GpWebpay extends PaymentGatewayApi {

	function testingApi(){
		return GP_WEBPAY_TESTING;
	}

	function _getStartTransactionUrl(&$payment_transaction,&$transaction_id){
		$order = $payment_transaction->getOrder();
		$currency = $payment_transaction->getCurrency();

		$api = $this->_getApi();

		$request = new \AdamStipak\Webpay\PaymentRequest(
			$payment_transaction->getId(), // $orderNumber: Číslo platby. Číslo musí být v každém požadavku od obchodníka unikátní.
			$payment_transaction->getPriceToPay(), // $amount
			"$currency"=="CZK" ? \AdamStipak\Webpay\PaymentRequest::CZK : \AdamStipak\Webpay\PaymentRequest::EUR, // $currency
			1, // $depositFlag: 0 = není požadována okamžitá úhrada; 1 = je požadována úhrada
			\Atk14Url::BuildLink(["namespace" => "", "action" => "gp_webpay/finish_transaction", "token" => $payment_transaction->getToken()],["with_hostname" => true]), // $url
			$order->getOrderNo() // $merOrderNumber: Číslo platby. Zobrazí se na výpisu z banky. V případě, že není zadáno, použije se hodnota ORDERNUMBER.
		);

		return $api->createPaymentRequestUrl($request);

		//$payment_transaction->s([
		//	"payment_transaction_started_at" => now(),
		//	"payment_transaction_started_from_addr" => $this->request->getRemoteAddr(),
		//	"payment_transaction_id" => null,
		//	"payment_transaction_url" => $url,
		//	"testing_payment" => GP_WEBPAY_TESTING,
		//]);
	}

	// Neuspesny pokus
	//	function _updateStatus(&$payment_transaction){
	//		$order = $payment_transaction->getOrder();
	//		$signer = $this->_getSigner();
	//
	//		$api = $this->_getApi();
	//
	//		$request = $GLOBALS["HTTP_REQUEST"];
	//
	//		var_dump($request->getGetVar("OPERATION"));
	//		var_dump($request->getGetVar("ORDERNUMBER"));
	//		var_dump((string)$request->getGetVar("MERORDERNUM"));
	//		var_dump($request->getGetVar("PRCODE"));
	//		var_dump($request->getGetVar("SRCODE"));
	//		var_dump($request->getGetVar("RESULTTEXT"));
	//		var_dump($request->getGetVar("DIGEST"));
	//		var_dump($request->getGetVar("DIGEST1"));
	//
	//		$response = new \AdamStipak\Webpay\PaymentResponse(
	//			$request->getGetVar("OPERATION"),
	//			$request->getGetVar("ORDERNUMBER"),
	//			(string)$request->getGetVar("MERORDERNUM"),
	//			$request->getGetVar("PRCODE"),
	//			$request->getGetVar("SRCODE"),
	//			$request->getGetVar("RESULTTEXT"),
	//			$request->getGetVar("DIGEST"),
	//			$request->getGetVar("DIGEST1")
	//		);
	//
	//		$result = $api->verifyPaymentResponse($response);
	//		var_dump($result);
	//
	//		exit;
	//	}

	protected function _getCurrentPaymentStatusCode(&$payment_transaction){
		$data = $this->_getStatus($payment_transaction);
		if(is_null($data)){
			return;
		}

		$status = $data["status"];
		myAssert(strlen($status)>0);

		$tr = [
			"PENDING_AUTHORIZATION" => "pending", 	// Nově založená objednávka příchozí libovolným kanálem, kterou je stále možné úspěšně dokončit. U PUSH plateb je to do konce platnosti nebo vyčerpání pokusů, u ostatních plateb do konce platnosti session.
			"UNPAID" => "cancelled", 								// Každá objednávka, která nebyla z libovolného důvodu úspěšně autorizována. Od technických příčin, přes zamítnutí na úrovni MPI (3D ověření), FDS (Fraud detection system) či AC (Autorizační centrum) až po opuštění platby nebo návratu do eShopu bez dokončení. 
			"PENDING_CAPTURE" => "pending", 				// Autorizovaná/schválená platba, došlo úspěšně k blokaci finančních prostředků na účtu nakupujícího. Nebyl dosud vytvořen žádný požadavek na stržení blokované částky (capture).
			"REVERSED" => "cancelled", 							// Stornovaná platba – buď manuálně (přes GUI nebo WS) obchodníkem nebo systémem při vypršení doby pro provedení stržení částky (capture) ze stavu PENDING_CAPTURE.
			"CAPTURED" => "paid",										// K objednávce existuje plný deposit bez ohledu na to, zda byl již zpracován nebo na to čeká a lze tudíž ještě zrušit.
			"PENDING_ADJUSTMENT" => "pending",			// Pro použití v oblasti AFD (Automatic fuel dispenser) se bude po úvodní autorizaci čekat na určení přesné částky, na kterou se má ponížit blokace prostředků.
			"PARTIAL_PAYMENT" => "pending",					// Částečně uhrazená platba – nebyla stržena celá blokovaná částka nebo byly částečně vráceny peníze zpět držiteli platební karty.
			"REFUNDED" => "cancelled",							// Kompletně vrácená platba – veškeré stržené peníze byly vráceny držiteli platební karty, bez ohledu, zda byla stržena celková blokovaná částka.
		];
		myAssert(isset($tr[$status]),"unknown status: $status");

		$code = $tr[$status];

		return $code;
	}

	function _getStatus($payment_transaction){
		$signer = $this->_getSigner();

		$params = [
			"messageId" => $payment_transaction->getId()."x".uniqid().uniqid(),
			"provider" => GP_WEBPAY_PROVIDER_CODE,
			"merchantNumber" => GP_WEBPAY_MERCHANT_NUMBER,
			"paymentNumber" => $payment_transaction->getId(),
		];
		$params["signature"] = $signer->sign($params);

		$xml = [];
		$xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml[] = '<soapenv:Envelope xmlns:v1="http://gpe.cz/pay/pay-ws/proc/v1" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:type="http://gpe.cz/pay/pay-ws/proc/v1/type">';
		$xml[] = '<soapenv:Header/>';
		$xml[] = '<soapenv:Body>';

		$xml[] = '<v1:getPaymentStatus>';
		$xml[] = '<v1:paymentStatusRequest>';

		foreach($params as $k => $v){
			$xml[] = "<type:$k>".\XMole::ToXml($v)."</type:$k>";
		}

		$xml[] = '</v1:paymentStatusRequest>';
		$xml[] = '</v1:getPaymentStatus>';

		$xml[] = '</soapenv:Body>';
		$xml[] = '</soapenv:Envelope>';
			
		$xml = join("\n",$xml);
		$url = GP_WEBPAY_WS_URL;

		$uf = new \UrlFetcher($url);
		$uf->post($xml,["content_type" => "text/xml"]);

		$content = $uf->getContent();
		$status_code = $uf->getStatusCode();

		if($status_code==500){
			$this->logger->warn("Status code is 500, skipping the check (content: $content)");
			return;
		}

		myAssert($uf->found(),"Invalid HTTP status code: ".$uf->getStatusCode());
		$xmole = new \XMole();
		$stat = $xmole->parse($content);
		myAssert($stat,"Failed to parse XML (".$xmole->get_error_message()."): ".$content);

		/*
		 *	<?xml version="1.0" encoding="UTF-8"?>
		 *	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		 *		<soapenv:Body>
		 *			<ns4:getPaymentStatusResponse xmlns:ns4="http://gpe.cz/pay/pay-ws/proc/v1" xmlns:ns2="http://gpe.cz/pay/pay-ws/core/type" xmlns="http://gpe.cz/gpwebpay/additionalInfo/response" xmlns:ns3="http://gpe.cz/pay/pay-ws/proc/v1/type" xmlns:ns5="http://gpe.cz/gpwebpay/additionalInfo/response/v1">
		 *				<ns4:paymentStatusResponse>
		 *					<ns3:messageId>9x5a33c9f2c844e5a33c9f2c848a</ns3:messageId>
		 *					<ns3:state>7</ns3:state>
		 *					<ns3:status>CAPTURED</ns3:status>
		 *					<ns3:subStatus>PENDING_CAPTURE_SETTLEMENT</ns3:subStatus>
		 *					<ns3:signature>D+8N/O0+yCYAjMu9w3D1IzsMMOUBAyiAMI9srRA+OR9xBkNwmAOp53SJ+Kn7FNiQpO0/WVEp8hxovzhOn9ppG6LuQEbI0syKGKa6Y8Ub+s+g9g9Klqzroey3tHsZS+4CULc/aX2Jak5tNDfCQObpK9Xi+zdyujK9VSRGAyXmQXfR7PlGYEEDneMi2oXZo1JxMP/8NOW1bWzeVZ/luD+xvEesQy4pzoGhIXFOHLMDNcPZ4X8HYva0b+V5GIwVhHEJAXgJ67VOztHAv8CZYeFQkVMqt5HrCZndcUFxCfGUZwhhoGv9AMtx2t2Iiy71ssMzlarZ0Bvv+ogCFp3dHzzj9Q==</ns3:signature>
		 *				</ns4:paymentStatusResponse>
		 *			</ns4:getPaymentStatusResponse>
		 *		</soapenv:Body>
		 *	</soapenv:Envelope>
		 */


		$branch = $xmole->get_first_matching_branch('/soapenv:Envelope/soapenv:Body/ns4:getPaymentStatusResponse/ns4:paymentStatusResponse');
		myAssert($branch);

		$status_ar = [];
		foreach($branch["children"] as $v){
			$key = $v["element"];
			$value = $v["data"];

			$key = preg_replace('/^ns3:/','',$key);
			$status_ar[$key] = $value;
		}
		myAssert($status_ar);

		return $status_ar;
	}

	protected function _getSigner(){
		$signer = new \AdamStipak\Webpay\Signer(
			GP_WEBPAY_PRIVATE_KEY,						// Path of private key.
			GP_WEBPAY_PRIVATE_KEY_PASSWORD,		// Password for private key.
			GP_WEBPAY_PRIVATE_KEY							// Path of public key. Wtf? Ale ja public key nemam! :)
		);
		return $signer;
	}

	protected function _getApi(){
		$signer = $this->_getSigner();
		$api = new \AdamStipak\Webpay\Api(
			GP_WEBPAY_MERCHANT_NUMBER,		// Merchant number.
			GP_WEBPAY_URL,								// URL of webpay.
			$signer												// instance of \AdamStipak\Webpay\Signer.
		);
		return $api;
	}
}