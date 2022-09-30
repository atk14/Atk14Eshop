<?php
class TcFloatToHour extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.float_to_hour");

		$this->assertEquals("1:00",smarty_modifier_float_to_hour("1"));
		$this->assertEquals("13:11",smarty_modifier_float_to_hour("13.20"));
		$this->assertEquals("13.11",smarty_modifier_float_to_hour("13.20","H.i"));

		$this->assertEquals("",smarty_modifier_float_to_hour(""));
	}
}
