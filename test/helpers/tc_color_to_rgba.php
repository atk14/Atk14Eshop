<?php
class TcColorToRgba extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.color_to_rgba");

		$this->assertEquals("rgba(0,17,255,0.5)",smarty_modifier_color_to_rgba("#0011ff","0.5"));
		$this->assertEquals("rgba(0,17,255,1.0)",smarty_modifier_color_to_rgba("#0011ff")); // 1 is default

		$this->assertEquals("",smarty_modifier_color_to_rgba("","0.5"));
		$this->assertEquals("",smarty_modifier_color_to_rgba("nonsence","0.5"));
	}
}
