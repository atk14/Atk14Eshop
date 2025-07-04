<?php
/**
 *
 * @fixture products
 * @fixture pricelist_items
 * @fixture user_special_pricelists
 * @fixture users
 * @fixture currencies
 */
class TcPriceFinder extends TcBase {

	function test(){
		$pf = PriceFinder::GetInstance();
		$price = $pf->getPrice($this->products["mint_tea"]);
		$this->assertNotNull($price);
		$this->assertEquals(20.0,$price->getPrice());
		$this->assertFalse($price->discounted());
		$this->assertNull($price->discountedFrom());
		$this->assertNull($price->discountedTo());
		$this->assertEquals(0.0, $price->getDiscountPercent());
		$opp = $price->getOriginalProductPrice();
		$this->assertNull($opp);

		$yesterday = Date::Yesterday();
		$tomorrow = Date::Tomorrow();
		Discount::CreateNewRecord(["product_id" => $this->products["black_tea"], "discount_percent" => 10, "valid_from" => $yesterday, "valid_to" => $tomorrow]);
		Cache::Clear();
		$price = $pf->getPrice($this->products["black_tea"]);
		$this->assertNotNull($price);
		$this->assertEquals(17.1,$price->getPrice());
		$this->assertTrue($price->discounted());
		$this->assertEquals("{$yesterday} 00:00:00", $price->discountedFrom());
		$this->assertEquals("{$tomorrow} 00:00:00", $price->discountedTo());
		$this->assertEquals(10, $price->getDiscountPercent());
		$opp = $price->getOriginalProductPrice();
		$this->assertNotNull($opp);
		$this->assertEquals(19.0,$opp->getPrice());
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

	function test_special_pricelists(){
		$pf_rambo = PriceFinder::GetInstance($this->users["rambo"]);
		
		$price = $pf_rambo->getPrice($this->products["book"]);
		$this->assertEquals(199.0,$price->getPriceInclVat()); // price from the special price list

		$price = $pf_rambo->getPrice($this->products["jehla"],1);
		$this->assertEquals(1.3,$price->getPriceInclVat()); // not better price in the special price list

		// --

		$pf_anonymous = PriceFinder::GetInstance(User::GetAnonymousUser());

		$price = $pf_anonymous->getPrice($this->products["book"]);
		$this->assertEquals(279.0,$price->getPriceInclVat());
	}
}
