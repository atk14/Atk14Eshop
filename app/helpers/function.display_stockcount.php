<?php
/**
 *
 *	{display_stockcount product=$product}
 *	{display_stockcount card=$card}
 */
function smarty_function_display_stockcount($params,$template){
	$params += array(
		"product" => null,
		"card" => null,
		"display_nothing_if_can_be_ordered" => false,
	);

	if($params["card"]){
		$products = $params["card"]->getProducts();
	}elseif($params["product"]){
		$products = [$params["product"]];
	}else{
		return;
	}

	if(!$products){ return; }
	$product = $products[0]; // the first product
	$unit = $products[0]->getUnit();
	$max = 0;
	foreach($products as $_product){
		if($_product->getUnitId()!==$unit->getId()){ return; } // mixed units
		if(!$_product->canBeOrdered()){ continue; }
		$max += $_product->getCalculatedMaximumQuantityToOrder(["real_quantity" => true]);

		// we need to find the right product for the template
		if(!$product->canBeOrdered()){ $product = $_product; }
		if(!$_product->considerStockcount()){ $product = $_product; }
	}

	if($params["display_nothing_if_can_be_ordered"] && $product->canBeOrdered()){
		return;
	}

	$stockcount = $max / $unit->getDisplayUnitMultiplier();
	$stockcount_precision = ceil(log10($unit->getDisplayUnitMultiplier())); // 100 -> 2; 1000 -> 3; 1 -> 0

	$template->assign("product",$product);
	$template->assign("card",$product->getCard());
	$template->assign("unit",$unit);
	$template->assign("stockcount",$stockcount);
	$template->assign("stockcount_precision",$stockcount_precision);

	return trim($template->fetch("shared/helpers/_display_stockcount.tpl"));
}
