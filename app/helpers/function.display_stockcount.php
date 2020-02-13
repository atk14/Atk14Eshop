<?php
/**
 *
 *	{display_stockcount product=$product}
 */
function smarty_function_display_stockcount($params,$template){
	$params += array(
		"product" => null,
	);

	if(!$params["product"]){
		return;
	}

	$product = $params["product"];
	$max = $product->getCalculatedMaximumQuantityToOrder();
	$min = $product->getCalculatedMinimumQuantityToOrder();

	$unit = $product->getUnit();
	$stockcount = $max / $unit->getDisplayUnitMultiplier();
	$stockcount_precision = ceil(log10($unit->getDisplayUnitMultiplier())); // 100 -> 2; 1000 -> 3; 1 -> 0

	$template->assign("product",$product);
	$template->assign("unit",$unit);
	$template->assign("stockcount",$stockcount);
	$template->assign("stockcount_precision",$stockcount_precision);

	return trim($template->fetch("shared/helpers/_display_stockcount.tpl"));
}
