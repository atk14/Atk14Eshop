<?php
/**
 * Vygeneruje odkaz na prodejnu
 *
 * <a href="{$store|link_to_store}">{$product->getName()}</a>
 */
function smarty_modifier_link_to_store($store){
	$params = [
		"namespace" => "",
		"controller" => "stores",
		"action" => "detail",
		"id" => $store,
	];

	return Atk14Url::BuildLink($params);
}
