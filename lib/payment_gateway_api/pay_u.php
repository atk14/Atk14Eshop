<?php
namespace PaymentGatewayApi;

class PayU extends PaymentGatewayApi {

	protected $set_new_new_transaction_to_started_state = false;
	
	function _getStartTransactionUrl(&$payment_transaction,&$transaction_id){
		$order = $payment_transaction->getOrder();
		return \Atk14Url::BuildLink([
			"namespace" => "",
			"controller" => "pay_u",
			"action" => "start_transaction",
			"token" => $order->getToken(), // $order je tu a nikoli $payment_transaction!
		],[
			"with_hostname" => true,
		]);
	}

	protected function _getCurrentPaymentStatusCode(&$payment_transaction){
		$order = $payment_transaction->getOrder();
		$status = $this->_getPaymentStatus($payment_transaction,$err_code,$err_message);
		if(!$status){
			$this->logger->warn(sprintf("payment status cannot be checked for PaymentTransaction#%s (Order#%s, order_no=%s): %s (%s)",$payment_transaction->getId(),$order->getId(),$order->getOrderNo(),$err_message,$err_code));
			return;
		}

		$tr = [
			"pending" => [
				"1", // new
				"4", // started
				"5", // awaiting receipt
			],
			"paid" => [
				"99", // payment received - ended
			],
			"cancelled" => [
				"2", // cancelled
				"3", // rejected
				"7", // payment rejected
			],
		];

		foreach($tr as $code => $statuses){
			if(in_array($status->getStatus(),$statuses)){
				return $code;
			}
		}

		$this->logger(sprintf("unknown payment status for PaymentTransaction#%s (Order#%s, order_no=%s): %s (%s)",$payment_transaction->getId(),$order->getId(),$order->getOrderNo(),$status->getStatus(),$status->getStatusDescription()));
	}

	function renderForm($payment_transaction){
		global $HTTP_REQUEST;
		$order = $payment_transaction->getOrder();

		$prefered_pay_type = null;
		//$prefered_pay_type = "kb";

		//<script language="JavaScript" type="text/JavaScript" src="https://secure.payu.com/jsgenerator/js/jquery-latest.js"></script>

		$fields = array(
			"pos_id" => \PAYU_POS_ID,
			"session_id" => $payment_transaction->getId(), // TODO: $this->_transaction->getPayuSessionId(), // ??
			"pos_auth_key" => \PAYU_POS_AUTH_KEY,
			//"amount" => number_format(($order->getTotalPriceInclVat() * 100),2,".",""), // v halerich!!! asi to ma byy bez des. mist...
			"amount" => ($payment_transaction->getPriceToPay() * 100), // v halerich!!! asi to ma byt bez des. mist...
			// TODO: currency!
			"desc" => sprintf(_("Objednávka č. %s v e-shopu %s"),$order->getOrderNo(),\ATK14_APPLICATION_NAME), // TODO: $this->_description,
			"desc2" => $this->_getOrderDescription($order), sprintf(_("Objednávka v e-shopu %s"),\ATK14_APPLICATION_NAME), // TODO: substr($order->getDescription(),0,1024),
			"order_id" => $order->getOrderNo(),
			"first_name" => $order->getFirstname(),
			"last_name" => $order->getLastname(),
			"street" => $order->getAddressStreet(),
			//"street_hn" => $order->getAddrNumber(),
			"city" => $order->getAddressCity(),
			"post_code" => $order->getAddressZip(),
			"country" => $order->getAddressCountry(), // "cz"
			"email" => $order->getEmail(),
			"phone" => $order->getDeliveryPhone(),
			"language" => $order->getLanguage(), // kdyz je zde cz, objevi se tam polstina
			"client_ip" => $HTTP_REQUEST->getRemoteAddr(),
			"ts" => time(),
		);

		// http://developers.payu.com/en/classic_api.html#classic_api_new_payment_parameters
		foreach(["first_name","last_name","street","city","email","phone"] as $k){
			$fields[$k] = mb_substr($fields[$k],0,100);
		}

		if($prefered_pay_type){
			// tady zname dopredu typ platby
			$fields["pay_type"] = $prefered_pay_type;
			$fields["sig"] = $this->_calcSignature($fields,array("consider_pay_type" => true));

			$content .= '<form action="https://secure.payu.com/paygw/UTF/NewPayment" method="post" name="payform" id="payform">';
			$content .= $this->_renderHiddenFields($fields);

			$content .= '
				<input type="hidden" name="js" value="0" id="payform_js" />
				<!-- input type="submit" value="Zaplatit" / -->
				</form>

				<script language="JavaScript" type="text/javascript">
				<!--
				document.getElementById("payform_js").setAttribute("value","1");
				document.getElementById("payform").submit();
				-->
				</script>
			';
			return $content;
		}

		// tady je ext_calc:0 -> tj. v signarute nepocitame s pay_type
		$content = sprintf('
		<script language="javascript" type="text/javascript" src="https://secure.payu.com/paygw/UTF/js/%s/%s/template:3/ext_calc:0/paytype.js"></script>
		',\PAYU_POS_ID,substr(\PAYU_KEY1,0,2));
	
		$content .= '<form action="https://secure.payu.com/paygw/UTF/NewPayment" method="post" name="payform" id="payform">';

		/* // !! pokud pocitame signature, radeji to prevedema na ASCII, ono to totiz vypada, ze ten podpis se pocita z UTF-8 hodnot
		$fields = Translate::Trans($fields,DEFAULT_CHARSET,"ASCII");
		// */
		$fields["sig"] = $this->_calcSignature($fields,array("consider_pay_type" => false)); // v URL na javascript je ext_calc:0, tak proto je "consider_pay_type" vypnuto

		$content .= $this->_renderHiddenFields($fields);

		$content .= '
			<script language="JavaScript" type="text/JavaScript">
			PlnPrintTemplate();
			</script>
		';	
		$content .= '
			<input type="hidden" name="js" value="0" id="payform_js" />
			<input type="submit" value="Zaplatit" />
			</form>

			<script language="JavaScript" type="text/javascript">
			<!--
			document.getElementById("payform_js").setAttribute("value","1");
		';

		if($prefered_pay_type){
			$content .= 'document.getElementById("payform").submit();';
		}
		
		$content .=	'
		-->
			</script>
		';

		return $content;
	}

	function _renderHiddenFields($fields){
		$out = array();
		foreach($fields as $name => $value){
			$out[] = '<input type="hidden" name="'.h($name).'" value="'.h($value).'" />';
		}
		return join("\n",$out);
	}

	function _calcSignature($ary,$salt = null,$options = array()){
		if(is_array($salt)){
			$options = $salt;
			$salt = null;
		}

		if(!isset($salt)){
			$salt = \PAYU_KEY1;
		}

		$options += array(
			"consider_pay_type" => true,
		);
	
		//return md5($ary["pos_id"].$ary["session_id"].$ary["ts"].$salt);
		$keys = array(
			"pos_id",
			"pay_type",
			"session_id",
			"pos_auth_key",
			"amount",
			"desc",
			"desc2",
			"order_id",
			"first_name",
			"last_name",
			"street",
			"street_hn",
			"street_an",
			"city",
			"post_code",
			"country",
			"email",
			"phone",
			"language",
			"client_ip",
			"ts"
		);

		$out = "";
		foreach($keys as $k){
			if($k=="pay_type" && !$options["consider_pay_type"]){
				continue;
			}
			$out .= isset($ary[$k]) ? $ary[$k] : "";
		}
		$out .= $salt;
		
		// $out = Translate::Trans($out,DEFAULT_CHARSET,"UTF-8"); // TODO: vypada to, ze to chteji jen v UTF-8

		return md5($out);
	}

	function _getPaymentStatus($payment_transaction,&$err_code,&$err_message){
		$uf = new \UrlFetcher("https://secure.payu.com/paygw/UTF/Payment/get");
		$params = array(
			"pos_id" => PAYU_POS_ID,
			"session_id" => $payment_transaction->getId(),
			"ts" => time(),
		);

		$params["sig"] = $this->_calcSignature($params);

		//var_dump($params);
		
		if($uf->post($this->_build_params($params))){
			if(!$out = PayU\PaymentStatus::GetInstance($uf->getContent(),$err_code,$err_message,$options = array("key2" => PAYU_KEY2))){
				return null;
			}
			if($out->getPosId()!=PAYU_POS_ID){
				$err_message = sprintf("incorrect pos id %s!=%s",$out->getPosId(),PAYU_POS_ID);
				return null;
			}
			if(!$out->signatureValid()){
				$err_message = "incorrect signature";
				return null;
			}
			return $out;
		}

		$err_message = "network error: ".$uf->getErrorMessage();
	}

	function _build_params($params){
		$out = array();
		foreach($params as $k => $v){
			$out[] = "$k=".urlencode($v);
		}
		return join("&",$out);
	}

}
