<?php
class TcToAscii extends TcBase {

	function test_modifier(){
		Atk14Require::Helper("modifier.to_ascii");
		
		$this->assertEquals("Misa Kulicka",smarty_modifier_to_ascii("Míša Kulička"));
	}

	function test_block(){
		Atk14Require::Helper("block.to_ascii");

		$content = "Míša Kulička";
		$params = array();
		$smarty = new Atk14Smarty();

		$repeat = true;
		$this->assertEquals(null,smarty_block_to_ascii($params,$content,$smarty,$repeat));

		$repeat = false;
		$this->assertEquals("Misa Kulicka",smarty_block_to_ascii($params,$content,$smarty,$repeat));
	}
}
