<?php
class TcColorToRgba extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.color_to_rgba");

		$this->assertEquals("rgba(0,17,255,0.5)",smarty_modifier_color_to_rgba("#0011ff","0.5"));
		$this->assertEquals("rgba(0,17,255,1)",smarty_modifier_color_to_rgba("#0011ff")); // 1 is default

		$this->assertEquals("rgba(0,17,255,1)",smarty_modifier_color_to_rgba("#0011FFAA")); // hexa

		$this->assertEquals("rgba(170,187,204,0.5)",smarty_modifier_color_to_rgba("#abc","0.5"));

		$this->assertEquals("rgba(1,2,3,0.5)",smarty_modifier_color_to_rgba("rgb(1,2,3)","0.5"));

		$this->assertEquals("rgba(33,44,55,1)",smarty_modifier_color_to_rgba("rgba(33,44,55,0.3)"));
		$this->assertEquals("rgba(33,44,55,0.5)",smarty_modifier_color_to_rgba("rgba(33.3, 44.4, 55.5, 0.3)","0.5"));

		// named colors - see vendor/aristath/ari-color/aricolor.php
		$this->assertEquals("rgba(255,0,0,1)",smarty_modifier_color_to_rgba("RED"));
		$this->assertEquals("rgba(238,130,238,1)",smarty_modifier_color_to_rgba("violet"));

		$this->assertEquals("",smarty_modifier_color_to_rgba("","0.5"));
		$this->assertEquals("rgba(255,255,255,0.5)",smarty_modifier_color_to_rgba("nonsence","0.5")); // fallback
	}
}
