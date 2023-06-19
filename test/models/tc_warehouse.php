<?php
/**
 *
 * @fixture warehouses
 * @fixture products
 */
class TcWarehouse extends TcBase {

	function test_GetDefaultInstance4Eshop(){
		$w1 = Warehouse::CreateNewRecord([
			"applicable_to_eshop" => true,
		]);
		$w1->setRank(0);
		//
		$w = Warehouse::GetDefaultInstance4Eshop(["flush_cache" => true]);
		$this->assertEquals($w1->getId(),$w->getId());

		$w2 = Warehouse::CreateNewRecord([
			"applicable_to_eshop" => false,
		]);
		$w2->setRank(0);
		//
		$w = Warehouse::GetDefaultInstance4Eshop(["flush_cache" => true]);
		$this->assertEquals($w1->getId(),$w->getId());

		$w3 = Warehouse::CreateNewRecord([
			"applicable_to_eshop" => true,
		]);
		$w3->setRank(0);
		//
		$w = Warehouse::GetDefaultInstance4Eshop(["flush_cache" => true]);
		$this->assertEquals($w3->getId(),$w->getId());
	}

	function test_addProduct(){
		$warehouse = $this->warehouses["external"];
		$black_tea = $this->products["black_tea"];

		$this->assertEquals(0,$warehouse->getProductStockcount($black_tea));

		$warehouse->addProduct($black_tea,10);
		$this->assertEquals(10,$warehouse->getProductStockcount($black_tea));

		$warehouse->addProduct($black_tea->getId(),-2);
		$this->assertEquals(8,$warehouse->getProductStockcount($black_tea->getId()));

		// price_rounding is ignored in Product::addProduct()

		$price_rounding = Product::GetInstanceByCode("price_rounding");
		$this->assertTrue(!!$price_rounding);

		$this->assertEquals(0,$warehouse->getProductStockcount($price_rounding));

		$warehouse->addProduct($price_rounding,10);
		$this->assertEquals(0,$warehouse->getProductStockcount($price_rounding));

		$warehouse->addProduct($price_rounding->getId(),10);
		$this->assertEquals(0,$warehouse->getProductStockcount($price_rounding->getId()));
	}
}
