<?php
/**
 * @fixture currencies
 */
class TcDisplayPrice extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.display_price");

		$this->assertEquals("123 CZK",smarty_modifier_display_price(123.45,"CZK,show_decimals_on_czk=false,format=plain"));
		$this->assertEquals("123.45 EUR",smarty_modifier_display_price(123.45,"EUR,show_decimals_on_czk=false,format=plain"));
		$this->assertEquals("123.45000000 BTC",smarty_modifier_display_price(123.45,"BTC,show_decimals_on_czk=false,format=plain"));
	}
}
