<?php
/**
 *
 * @fixture products
 */
class TcProduct extends TcBase {

	function test_naming(){
		$peanuts = $this->products["peanuts"];
		$this->assertEquals("Peanuts",$peanuts->getName());
		$this->assertEquals("",$peanuts->getLabel());
		$this->assertEquals("Peanuts",$peanuts->getFullName());
		$this->assertEquals("Peanuts","$peanuts");

		$green_tea = $this->products["green_tea"];
		$this->assertEquals("Tea",$green_tea->getName());
		$this->assertEquals("green",$green_tea->getLabel());
		$this->assertEquals("Tea, green",$green_tea->getFullName());
		$this->assertEquals("Tea, green","$green_tea");

		$black_tea = $this->products["black_tea"];
		$this->assertEquals("Tea, black","$black_tea");
	}

	function test_destroy(){
		$green_tea = $this->products["green_tea"];
		$green_tea_id = $green_tea->getId();

		$this->assertEquals(false,$green_tea->isDeleted());
		$this->assertEquals("TEA_GREEN",$green_tea->getCatalogId());
		$this->assertEquals("TEA_GREEN",$green_tea->g("catalog_id"));

		$green_tea->destroy();

		$green_tea = Product::GetInstanceById($green_tea_id);
		$this->assertTrue(is_object($green_tea));
		$this->assertEquals(true,$green_tea->isDeleted());
		$this->assertEquals("TEA_GREEN",$green_tea->getCatalogId());
		$this->assertEquals("TEA_GREEN~deleted-$green_tea_id",$green_tea->g("catalog_id"));

		$gt = Product::GetInstanceByCatalogId("TEA_GREEN");
		$this->assertEquals($green_tea,$gt);

		$green_tea->destroy(true);

		$green_tea = Product::GetInstanceById($green_tea_id);
		$this->assertNull($green_tea);

		$gt = Product::GetInstanceByCatalogId("TEA_GREEN");
		$this->assertNull($gt);
	}

	function test_default_vat_rate(){
		$def_vr = VatRate::GetDefaultVatRate();
		$this->assertTrue(is_object($def_vr));

		$card = Card::CreateNewRecord([]);
		$prod = Product::CreateNewRecord([
			"catalog_id" => "TESTING",
			"card_id" => $card,
		]);

		$vat_rate = $prod->getVatRate();
		$this->assertTrue(is_object($vat_rate));

		$this->assertEquals($def_vr->getId(),$vat_rate->getId());
	}
}
