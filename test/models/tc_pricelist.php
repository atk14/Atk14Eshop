<?php
/**
 *
 * @fixture pricelists
 * @fixture products
 */
class TcPricelist extends TcBase {

	function test_setPrices(){
		$pricelist_1 = $this->pricelists["pricelist_1"];
		$pricelist_2 = $this->pricelists["pricelist_2"];

		$mint_tea = $this->products["mint_tea"];
		$black_tea = $this->products["black_tea"];
		$green_tea = $this->products["green_tea"];

		$pricelist_2->setPrices([
			$mint_tea->getId() => 17.0,
			$black_tea->getId() => 27.0,
		]);

		$pricelist_1->setPrices([
			$mint_tea->getId() => 20.0,
			$black_tea->getId() => 30.0,
		]);

		$this->assertEquals(20.0,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(30.0,$this->_get_price($pricelist_1,$black_tea));
		$this->assertEquals(null,$this->_get_price($pricelist_1,$green_tea));

		$pricelist_1->setPrices([
			$black_tea->getId() => 30.0,
			$green_tea->getId() => 40.0,
		]);

		$this->assertEquals(null,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(30.0,$this->_get_price($pricelist_1,$black_tea));
		$this->assertEquals(40.0,$this->_get_price($pricelist_1,$green_tea));

		$pricelist_1->setPrices([
			$mint_tea->getId() => 15.0,
			$black_tea->getId() => 25.0,
		],["delete_missing_prices" => false]);

		$this->assertEquals(15.0,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(25.0,$this->_get_price($pricelist_1,$black_tea));
		$this->assertEquals(40.0,$this->_get_price($pricelist_1,$green_tea));

		$this->assertequals(17.0,$this->_get_price($pricelist_2,$mint_tea));
		$this->assertequals(27.0,$this->_get_price($pricelist_2,$black_tea));
	}

	function test(){
		$pricelist_1 = $this->pricelists["pricelist_1"];
		$pricelist_2 = $this->pricelists["pricelist_2"];

		$mint_tea = $this->products["mint_tea"];
		$black_tea = $this->products["black_tea"];

		$pricelist_2->setPrice($mint_tea,15.0);
		$pricelist_2->setPrice($black_tea,25.0);

		$this->assertEquals(null,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(null,$this->_get_price($pricelist_1,$black_tea));

		$pricelist_1->setPrice($mint_tea,20.0);

		$this->assertEquals(20.0,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(null,$this->_get_price($pricelist_1,$black_tea));

		$pricelist_1->setPrice($black_tea,30.0);

		$this->assertEquals(20.0,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(30.0,$this->_get_price($pricelist_1,$black_tea));
		
		$pricelist_1->delPrice($mint_tea);

		$this->assertEquals(null,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(30.0,$this->_get_price($pricelist_1,$black_tea));

		$pricelist_1->delPrice($black_tea);

		$this->assertEquals(null,$this->_get_price($pricelist_1,$mint_tea));
		$this->assertEquals(null,$this->_get_price($pricelist_1,$black_tea));

		$this->assertequals(15.0,$this->_get_price($pricelist_2,$mint_tea));
		$this->assertequals(25.0,$this->_get_price($pricelist_2,$black_tea));
	}

	function _get_price($pricelist,$product){
		$dbmole = Pricelist::GetDbmole();

		$price = $dbmole->selectFloat("SELECT price FROM pricelist_items WHERE pricelist_id=:pricelist AND product_id=:product",[":pricelist" => $pricelist, ":product" => $product]);
		return $price;
	}
}
