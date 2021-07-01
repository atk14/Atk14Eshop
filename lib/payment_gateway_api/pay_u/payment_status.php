<?php
namespace PaymentGatewayApi\PayU;

class PaymentStatus {

	protected function __construct(){
		$this->_statusTr = array(
			"1" => array("desc" => "new", "desc_human" => _("nová platba")), // nova 
			"2" => array("desc" => "cancelled", "desc_human" => _("zrušeno")), // zrusena
			"3" => array("desc" => "rejected", "desc_human" => _("odmítnuto")), // odmitnuta
			"4" => array("desc" => "started", "desc_human" => _("zahájeno")), // zahajena
			"5" => array("desc" => "awaiting receipt", "desc_human" => _("očekává se potvrzení nebo přijetí platby")), // očekává se potvrzení (pro přijetí)
			"6" => array("desc" => "no authorization", "desc_human" => _("špatná autorizace")), // ?? co s tim?
			"7" => array("desc" => "payment rejected", "desc_human" => _("platba odmítnuta")), // platba zamítnuta; prostředky byly však od zákazníka přijaty po zrušení
																 //transakce nebo nebylo možné převést prostředky zpátky automaticky; takové situace monitoruje a objasňuje tým
																 // PayU – returning funds to client
			"99" => array("desc" => "payment received - ended", "desc_human" => _("platba přijata")), // 99 platba přijata – skončena
			"888" => array("desc" => "incorrect status", "desc_human" => _("nesprávný status - prosím, kontaktujte nás")), // nesprávný status – prosím, kontaktujte nás
		);

		$this->_typeTr = array(
			"mp" => array("desc" => "mPenize (mBank)", "payment_type_id" => 17),
			"kb" => array("desc" => "MojePlatba (Komerční banka)", "payment_type_id" => 18),
			"rf" => array("desc" => "ePlatby pro eKonto (Raiffeisenbank)", "payment_type_id" => 19),
			"pg" => array("desc" => "GE Money Bank", "payment_type_id" => 20),
			"pv" => array("desc" => "Volksbank", "payment_type_id" => 21),
			"pf" => array("desc" => "Fio banka", "payment_type_id" => 22),
			"c" => array("desc" => "Kreditní karty přes GPE", "payment_type_id" => 2),
			//"" => array("desc" => "Kreditní karty přes Moneybookers", "payment_type_id" => 2), // POZOR! v dokumentaci neni uveden zadny klic asi je to stejne jako "c"
			"bt" => array("desc" => "Bankovní převod", "payment_type_id" => 6),
			"pt" => array("desc" => "Převod přes poštu (poštovní poukázkou)", "payment_type_id" => 23),
			"sc" => array("desc" => "superCASH (Sazka)", "payment_type_id" => 24),
			"t" => array("desc" => "Testovací platba", "payment_type_id" => 25),

			"mo" => array("desc" => "Mobito", "payment_type_id" => 26),
			"cs" => array("desc" => "Platba 24 (Česká spořitelna)", "payment_type_id" => 27)
		);
	}

	/**
	 *	<?xml version="1.0" encoding="UTF-8"?>
	 * 	<response>
   *  <status>OK</status>
	 *	<trans>
	 *		<id>1152630</id>
	 *		<pos_id>830</pos_id>
	 *		<session_id>10472850</session_id>
	 *		<order_id>10472850</order_id>
	 *		<amount>3600</amount>
	 *		<status>1</status>
	 *		<pay_type>t</pay_type>
	 *		<pay_gw_name>pt</pay_gw_name>
	 *		<desc>nákup na IHNED.cz</desc>
	 *		<desc2>Hospodářské noviny ve flashovém prohlížeči</desc2>
	 *		<create>2011-12-09 15:59:41</create>
	 *		<init></init>
	 *		<sent></sent>
	 *		<recv></recv>
	 *		<cancel></cancel>
	 *		<auth_fraud>1</auth_fraud>
	 *		<ts>1323446869955</ts>
	 *		<sig>5bb86ccf0d5ad12bd29070e3f630a374</sig>
	 *	</trans>
	 */
	static function GetInstance($xml,&$err_code = null,&$err_message = null,$options = array()){
		$err_code = null;
		$err_message = null;

		$options += array(
			"key2" => \PAYU_KEY2,
		);

		$xmole = new \XMole();
		$xmole->set_encoding("utf-8");
		if(!$xmole->parse($xml,$err_code,$err_message)){
			return null;
		}

		$data = array();
		$status = $xmole->get_element_data("/response/status");
		if($b = $xmole->get_first_matching_branch("/response/trans")){
			foreach($b["children"] as $el){
				$data[$el["element"]] = $el["data"];
			}
		}

		//echo $xml; exit;
		//var_Dump($data);

		$out = new PaymentStatus();
		$out->_PAYU_KEY2 = $options["key2"];
		//$out->_data = \Translate::Trans($data,"utf-8",DEFAULT_CHARSET);
		$out->_data = $data;
		$out->_status = $status;
		$out->_xml = $xml;

		if($out->_isValid()){
			return $out;
		}

		$err_code = $xmole->get_element_data("/response/error/nr");
		$err_message = $xmole->get_element_data("/response/error/message");
		$err_message = str_replace('Kod błędu:','Error code:',$err_message);
	}

	function _isValid(){
		return $this->_status == "OK";
	}

	function signatureValid(){
		$sig = md5(
			$this->g("pos_id","utf-8").
			$this->g("session_id","utf-8").
			$this->g("order_id","utf-8").
			$this->g("status","utf-8").
			$this->g("amount","utf-8").
			$this->g("desc","utf-8").
			$this->g("ts","utf-8").
			$this->_PAYU_KEY2
		);
		return $sig == $this->g("sig");
	}

	function toArray($encoding = DEFAULT_CHARSET){ return \Translate::Trans($this->_data,"utf-8",$encoding); }

	function getXml(){ return $this->_xml; }

	function g($key,$encoding = DEFAULT_CHARSET){
		if(!isset($this->_data[$key])){
			throw new \Exception("Unknown key $key");
		}
		return isset($this->_data[$key]) ? \Translate::Trans($this->_data[$key],"utf-8",$encoding) : null;
	}

	function getId(){ return $this->g("id"); }

	function getSessionId(){ return $this->g("session_id"); }

	function getStatus(){ return $this->g("status"); }
	function getStatusDescription(){
		$tr = $this->_statusTr;
		return isset($tr[$this->getStatus()]) ? $tr[$this->getStatus()]["desc"] : null;
	}

	// vrati hodnotu pro zaznam orders.payment_statu_id
	// tato funkce neni vubec hezka, protoze sesnerovava PayU a inobj_Order
	function getPaymentStatusId(){
		$tr = $this->_statusTr;
		return isset($tr[$this->getStatus()]) ? $tr[$this->getStatus()]["payment_status_id"] : null;
	}

	function getPayType(){ return $this->g("pay_type"); }
	function getPayTypeDescription(){
		$tr = $this->_typeTr;
		return isset($tr[$this->getPayType()]) ? $tr[$this->getPayType()]["desc"] : null;
	}
	
	function getPaymentTypeId(){
		$tr = $this->_typeTr;
		return isset($tr[$this->getPayType()]) ? $tr[$this->getPayType()]["payment_type_id"] : 5;
	}

	/**
	 * Cena objednavky v halerich!!!!
	 * 123Kc -> amount bude 12300
	 */
	function getAmount(){
		return (float)$this->g("amount");
	}

	function getPosId(){ return $this->g("pos_id"); }
}
