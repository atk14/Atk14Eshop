<?php
/**
 * Builds a link to a store according to the given code
 *
 *	<a href="{"eshop"|link_to_store}">{$store->getName()}</a>
 *	<a href="{"eshop"|link_to_store:"with_hostname"}">{$store->getName()}</a>
 */
function smarty_modifier_link_to_store($code,$options = ""){
	if(is_object($code)){
		$store = $code;
	}else{
		$store = Store::GetInstanceByCode($code);
	}

	$options = Atk14Utils::StringToOptions($options);

	if(!$store){
		PRODUCTION && trigger_error("Unknown store code: $code", E_USER_WARNING);
		return Atk14Url::BuildLink(array("namespace" => "", "controller" => "main", "action" => "page_not_found", "store" => $code),$options);
	}

	return Atk14Url::BuildLink(array("namespace" => "", "controller" => "stores", "action" => "detail", "id" => $store),$options);
}
