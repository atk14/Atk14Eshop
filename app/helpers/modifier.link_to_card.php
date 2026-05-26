<?php
/**
 * Builds link to a card
 *
 *	<a href="{$card|link_to_card:"with_hostname"}">{$card->getName()}</a>
 */
function smarty_modifier_link_to_card($card,$options = array()){
	$options = Atk14Utils::StringToOptions($options);

	if(!$card){
		return;
	}

	$params = [
		"namespace" => "",
		"controller" => "cards",
		"action" => "detail",
		"id" => $card,
	];

	// Link to the first product variant, which can be ordered if the first variant is not available for ordering
	if($card->hasVariants() && count($products = $card->getProducts())>1 && !$products[0]->canBeOrdered()){
		$first_orderable_product = null;
		foreach(array_slice($products,1) as $product){
			if($product->canBeOrdered()){
				$first_orderable_product = $product;
				break;
			}
		}
		if($first_orderable_product){
			$params["product_id"] = $first_orderable_product;
		}
	}

	return Atk14Url::BuildLink($params,$options);
}
