<?php
/**
 *
 * @fixture products
 * @fixture warehouses
 * @fixture warehouse_items
 * @fixture watched_products
 */
class TcWatchedProduct extends TcBase {

	function test(){
		$warehouse = Warehouse::GetDefaultInstance4Eshop();

		$watched_products = WatchedProduct::GetWatchedProductsToNotify();
		$this->assertEquals(0,sizeof($watched_products));

		$warehouse->addProduct($this->products["fridge"],2);

		// product is not visible
		$this->products["fridge"]->s("visible",false);
		$watched_products = WatchedProduct::GetWatchedProductsToNotify();
		$this->assertEquals(0,sizeof($watched_products));

		// visible product
		$this->products["fridge"]->s("visible",true);
		$watched_products = WatchedProduct::GetWatchedProductsToNotify();
		$this->assertEquals(2,sizeof($watched_products));
	}
}
