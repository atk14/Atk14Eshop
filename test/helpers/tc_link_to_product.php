<?php
/**
 *
 * @fixture products
 */
class TcLinkToProduct extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.link_to_product");

		// the product is a variant
		$this->assertEquals("/drink/tea/mint/",smarty_modifier_link_to_product($this->products["mint_tea"]));

		// the product which is not a variant
		$this->assertEquals("/product/peanuts/",smarty_modifier_link_to_product($this->products["peanuts"]));

		$this->assertEquals("",smarty_modifier_link_to_product(""));
	}
}
