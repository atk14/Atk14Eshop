<?php
/**
 * This migration is continuation of 0042_sample_products_migration.php
 */
class UpdatingSampleProductsMigration extends ApplicationMigration {

	function up(){
		$card = Card::GetInstanceBySlug("neverending-story");
		if(!$card){ return; }

		$products = $card->getProducts();
		if(!$products){ return; }

		$product = $products[0];

		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		$warehouse && $warehouse->addProduct($product,12);

		$pricelist = Pricelist::GetDefaultPricelist();
		$pricelist && $pricelist->setPrice($product,345);
	}
}
