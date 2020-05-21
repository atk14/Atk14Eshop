<?php
class TcRemoveIfContainsNoText extends TcBase {

	function test(){
		Atk14Require::Helper("block.remove_if_contains_no_text");
		Atk14Require::Helper("modifier.remove_if_contains_no_text");

		$repeat = false;
		$params = [];
		$template = null;

		$content = "<p>Hello World!</p>";
		$this->assertEquals($content,smarty_block_remove_if_contains_no_text($params,$content,$template,$repeat));
		$this->assertEquals($content,smarty_modifier_remove_if_contains_no_text($content));

		$content = '<p><img src="image.jpg" alt="Sunset"></p>';
		$this->assertEquals("",smarty_block_remove_if_contains_no_text($params,$content,$template,$repeat));
		$this->assertEquals("",smarty_modifier_remove_if_contains_no_text($content));

		$content = "";
		$this->assertEquals("",smarty_block_remove_if_contains_no_text($params,$content,$template,$repeat));
		$this->assertEquals("",smarty_modifier_remove_if_contains_no_text($content));

		$content = " ";
		$this->assertEquals("",smarty_block_remove_if_contains_no_text($params,$content,$template,$repeat));
		$this->assertEquals("",smarty_modifier_remove_if_contains_no_text($content));
	}
}
