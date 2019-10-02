<?php
class TcDisplayNumber extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.display_number");

		$nbsp = html_entity_decode("&nbsp;");

		$this->assertEquals(null,smarty_modifier_display_number(""));
		$this->assertEquals("3",smarty_modifier_display_number(3));
		$this->assertEquals("3{$nbsp}000",smarty_modifier_display_number(3000));
		$this->assertEquals("0",smarty_modifier_display_number(0));
		$this->assertEquals("0,0001",smarty_modifier_display_number(0.0001));
		$this->assertEquals("3,23",smarty_modifier_display_number(3.23));
		$this->assertEquals("3,23",smarty_modifier_display_number(3.23));
		$this->assertEquals("3,00",smarty_modifier_display_number("3.00"));
		$this->assertEquals("1{$nbsp}003,23",smarty_modifier_display_number(1003.23));
		$this->assertEquals("-1{$nbsp}003,23",smarty_modifier_display_number(-1003.23));
	}
}
