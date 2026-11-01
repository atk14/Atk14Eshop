<?php
/**
 */
function smarty_modifier_catalog_id($product){
	return $product->getCatalogId();
}
