<?php
class TcLocalVatNumberField extends TcBase {

	function test(){
		$this->field = new TcLocalVatNumberField([]);

		$value = $this->assertValid("2034567890");
		$this->assertEquals("2034567890",$value);
	}
}
