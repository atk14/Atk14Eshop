<?php
/**
 *
 * @fixture cards
 * @fixture products
 * @fixture tags
 * @fixture pricelist_items
 * @fixture warehouse_items
 */
class TcProduct extends TcBase {

	function test_getName(){
		// Black tea has not its own name filled
		$black_tea = $this->products["black_tea"];
		$this->assertEquals("Tea, black",$black_tea->getName());
		$this->assertEquals("Tea",$black_tea->getName(false));
		$this->assertEquals("Čaj",$black_tea->getName("cs",false));
		$this->assertEquals("Tea, black",$black_tea->getFullName());
		$this->assertEquals("Čaj, černý",$black_tea->getFullName("cs"));

		// Green tea has its own name filled
		$green_tea = $this->products["green_tea"];
		$this->assertEquals("Green tea",$green_tea->getName());
		$this->assertEquals("Green tea",$green_tea->getName(false));
		$this->assertEquals("Zelený čaj",$green_tea->getName("cs",false));
		$this->assertEquals("Green tea",$green_tea->getFullName());
		$this->assertEquals("Zelený čaj",$green_tea->getFullName("cs"));

		// Peanuts do not have a label filled nor own name
		// The name is read from the card
		$peanuts = $this->products["peanuts"];
		$this->assertEquals("Peanuts",$peanuts->getName());
		$this->assertEquals("Peanuts",$peanuts->getName(false));
		$this->assertEquals("Arašídy",$peanuts->getName("cs",false));
		$this->assertEquals("Peanuts",$peanuts->getFullName());
		$this->assertEquals("Arašídy",$peanuts->getFullName("cs"));
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

	function test_containsTag(){
		$tag = $this->tags["fun"];

		$tea_card = $this->cards["tea"];
		$book_card = $this->cards["book"];

		$black_tea = $this->products["black_tea"];
		$green_tea = $this->products["green_tea"];
		$book = $this->products["book"];

		//

		$this->assertEquals(false,$black_tea->containsTag($tag));
		$this->assertEquals(false,$green_tea->containsTag($tag));
		$this->assertEquals(false,$book->containsTag($tag));

		//

		$black_tea->addTag($tag);
		$book->addTag($tag);

		$this->assertEquals(true,$black_tea->containsTag($tag));
		$this->assertEquals(false,$green_tea->containsTag($tag));
		$this->assertEquals(false,$book->containsTag($tag)); // it's because the book is not variant product

		//

		$tea_card->addTag($tag);
		$book_card->addTag($tag);

		$this->assertEquals(true,$black_tea->containsTag($tag));
		$this->assertEquals(true,$green_tea->containsTag($tag));
		$this->assertEquals(true,$book->containsTag($tag));
	}

	function test_canBeOrdered(){
		// mint_tea has price and is on stock
		$mint_tea = $this->products["mint_tea"];
		$this->assertEquals(true,$mint_tea->canBeOrdered());
		//
		$mint_tea->s("visible",false);
		$this->assertEquals(false,$mint_tea->canBeOrdered());
		$mint_tea->s("visible",true);
		$this->assertEquals(true,$mint_tea->canBeOrdered());
		$mint_tea->s("deleted",true);
		$this->assertEquals(false,$mint_tea->canBeOrdered());

		//green_tea has no price
		$green_tea = $this->products["green_tea"];
		$this->assertEquals(false,$green_tea->canBeOrdered());
	}
}
