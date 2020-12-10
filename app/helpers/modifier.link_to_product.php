<?php
/**
 * Builds link to a product
 *
 *	<a href="{$product|link_to_product:"with_hostname"}">{$product->getName()}</a>
 */
function smarty_modifier_link_to_product($product,$options = array()){
	$options = Atk14Utils::StringToOptions($options);

	if(!$product){
		return;
	}

	return Atk14Url::BuildLink(array("namespace" => "", "controller" => "cards", "action" => "detail", "id" => $product->getCardId()),$options);
}
