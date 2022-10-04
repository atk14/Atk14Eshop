<?php
/**
 *
 * @fixture products
 */
class TcLinkToProduct extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.link_to_product");

		$this->assertEquals("/drink/tea/",smarty_modifier_link_to_product($this->products["mint_tea"]));
		$this->assertEquals("/product/peanuts/",smarty_modifier_link_to_product($this->products["peanuts"]));
		$this->assertEquals("",smarty_modifier_link_to_product(""));
	}
}
