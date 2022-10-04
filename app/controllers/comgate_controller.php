<?php
require_once(__DIR__ . "/payment_gateways_base.php");

class ComgateController extends PaymentGatewaysBaseController {

	/**
	 *	comgate/finish_transaction request dump
	 *	---------------------------------------
	 *	remote addr: 89.185.236.55
	 *	request_uri: /cs/comgate/finish_transaction/
	 *	request_method: POST
	 *	raw_post_data:
	 *	merchant=134537&test=true&price=39900&curr=CZK&label=Objedn%C3%A1vka+na+D%C5%AFmL%C3%A1tek.cz+%28755060%29&refId=755060&cat=PHYSICAL&method=BANK_CZ_PS_P&email=yarri%40listonos.cz&phone=%2B420.605204527&transId=8MS0-JQR0-YGBL&secret=tXOymPjGXubCpQjjBkAHoPRbVE2lFRsy&status=PAID&fee=unknown&vs=35343685&payerName=Jaromir+Tomek&type=json
	 *	params:
	 *	Array
	 *	(
	 *	    [merchant] => 134537
	 *	    [test] => true
	 *	    [price] => 39900
	 *	    [curr] => CZK
	 *	    [label] => Objednávka na DůmLátek.cz (755060)
	 *	    [refId] => 755060
	 *	    [cat] => PHYSICAL
	 *	    [method] => BANK_CZ_PS_P
	 *	    [email] => yarri@listonos.cz
	 *	    [phone] => +420.605204527
	 *	    [transId] => 8MS0-JQR0-YGBL
	 *	    [secret] => tXOymPjGXubCpQjjBkAHoPRbVE2lFRsy
	 *	    [status] => PAID
	 *	    [fee] => unknown
	 *	    [vs] => 35343685
	 *	    [payerName] => Jaromir Tomek
	 *	    [type] => json
	 *	)
	 */
	function update_status(){
		if($pt = $this->_find_payment_transaction()){
			$comgate = new PaymentGatewayApi\Comgate();
			$comgate->updateStatus($pt);
		}

		$this->render_template = false;
		$this->response->setContentType("application/x-www-form-urlencoded");
		$this->response->write("code=0&message=OK");
	}

	function finish_transaction(){
		if($pt = PaymentTransaction::FindById($this->session->g("current_payment_transaction_id"))){
			$this->_redirect_to([
				"action" => "payment_transactions/finish",
				"token" => $pt->getToken(),
			]);
		}else{
			$this->_redirect_to("payment_transactions/finish");
		}
	}

	function _find_payment_transaction(){
		if($transId = $this->params->getString("transId")){
			$pg_code = "comgate";
			return PaymentTransaction::FindFirst("payment_transaction_id",$transId,"payment_gateway_id",PaymentGateway::FindByCode($pg_code),["order_by" => "created_at DESC"]);
		}
	}

	function _before_filter(){
		parent::_before_filter();

		$this->gateway = new PaymentGatewayApi\Comgate();
	}

}
