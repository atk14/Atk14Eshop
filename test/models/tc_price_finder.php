<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 * @fixture users
 * @fixture currencies
 */
class TcPriceFinder extends TcBase {

	function test(){
		$pf = PriceFinder::GetInstance();
		$price = $pf->getPrice($this->products["mint_tea"]);
		$this->assertNotNull($price);
		$this->assertFalse($price->discounted());
		$this->assertNull($price->discountedFrom());
		$this->assertNull($price->discountedTo());
		$this->assertEquals(0.0, $price->getDiscountPercent());

		$yesterday = Date::Yesterday();
		$tomorrow = Date::Tomorrow();
		Discount::CreateNewRecord(["product_id" => $this->products["black_tea"], "discount_percent" => 10, "valid_from" => $yesterday, "valid_to" => $tomorrow]);
		Cache::Clear();
		$price = $pf->getPrice($this->products["black_tea"]);
		$this->assertNotNull($price);
		$this->assertTrue($price->discounted());
		$this->assertEquals("{$yesterday} 00:00:00", $price->discountedFrom());
		$this->assertEquals("{$tomorrow} 00:00:00", $price->discountedTo());
		$this->assertEquals(10, $price->getDiscountPercent());
	}

	function test_GetCurrentInstance(){
		$pf = PriceFinder::GetCurrentInstance();
		$user = $pf->getUser();
		$currency = $pf->getCurrency();
		$this->assertTrue($user->isAnonymous());
		$this->assertEquals(DEFAULT_CURRENCY,$currency->getCode());
		
		PriceFinder::SetCurrentInstance(PriceFinder::GetInstance($this->users["rambo"],$this->currencies["bitcoin"]));
		
		$pf = PriceFinder::GetCurrentInstance();
		$user = $pf->getUser();
		$currency = $pf->getCurrency();
		$this->assertFalse($user->isAnonymous());
		$this->assertEquals($this->users["rambo"]->getId(),$user->getId());
		$this->assertEquals("BTC",$currency->getCode());
	}
}
