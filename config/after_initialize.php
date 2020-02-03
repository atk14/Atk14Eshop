<?php
try {

	$params = SystemParameter::GetAllInstances();

	foreach([
		"orders.order_no_offset" => "ORDER_NO_OFFSET",
		"eshop.default_region" => "DEFAULT_REGION",
		"eshop.default_currency" => "DEFAULT_CURRENCY",
		"merchant.billing_information.vat_id" => "VIES_REQUESTOR_VAT_NUMBER",
	] as $code => $constant){
		isset($params[$code]) && definedef($constant, $params[$code]->getContent());
	}

	// Pokud je zakaznik platce DPH, nastavime DEFAULT_VAT_RATE
	$default_vat_rate = null;
	$vat_payer = isset($params["merchant.vat_payer"]) ? $params["merchant.vat_payer"]->getContent() : null; // true, false, null
	if($vat_payer){
		$default_vat_rate = VatRate::FindFirst(); // it's Rankable
	}
	definedef("DEFAULT_VAT_RATE",$default_vat_rate ? $default_vat_rate->getCode() : null);

}catch(Exception $e){

	// $e->getMessage(): There is not table system_parameters in the database ondrejuv_obchudek_devel (postgresql)
	//if(!preg_match('/There is not table/',$e->getMessage())){
	//	throw($e);
	//}

}
