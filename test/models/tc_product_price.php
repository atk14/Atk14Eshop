<?php
/**
 * 
 * @fixture products
 * @fixture pricelist_items
 * @fixture discounts
 * @fixture users
 */
class TcProductPrice extends TcBase {

	function test_getPriceBeforeDiscount(){
		$price_finder = PriceFinder::GetInstance($this->users["rambo"]);

		$product_price = $price_finder->getPrice($this->products["popelin_s_oveckami"],100);

		$this->assertEquals(0.7388,$product_price->getUnitPrice());
		$this->assertEquals(73.88,$product_price->getPrice());
		$this->assertEquals(1.2314,$product_price->getUnitPriceBeforeDiscount());
		$this->assertEquals(123.14,$product_price->getPriceBeforeDiscount());
		$this->assertEquals(true,$product_price->discounted());

		$product_price_before_discount = $product_price->getProductPriceBeforeDiscount();
		$this->assertTrue(is_a($product_price_before_discount,"ProductPriceBeforeDiscount"));
		
		$this->assertEquals(1.2314,$product_price_before_discount->getUnitPrice());
		$this->assertEquals(1.49,$product_price_before_discount->getUnitPriceInclVat());
		$this->assertEquals(123.14,$product_price_before_discount->getPrice());
		$this->assertEquals(149.0,$product_price_before_discount->getPriceInclVat());
		$this->assertEquals(1.2314,$product_price_before_discount->getUnitPriceBeforeDiscount());
		$this->assertEquals(123.14,$product_price_before_discount->getPriceBeforeDiscount());
		$this->assertEquals(false,$product_price_before_discount->discounted());
	}
}
