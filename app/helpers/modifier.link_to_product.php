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

	$card = $product->getCard();

	$params = [
		"namespace" => "",
		"controller" => "cards",
		"action" => "detail",
		"id" => $card,
	];

	if($card->hasVariants() && count($card->getProducts())>1){
		$params["product_id"] = $product;
	}

	return Atk14Url::BuildLink($params,$options);
}
