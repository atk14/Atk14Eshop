<?php
class TcLocalVatNumberField extends TcBase {

	function test(){
		$this->field = new LocalVatNumberField([]);

		$value = $this->assertValid("2034567890");
		$this->assertEquals("2034567890",$value);
	}
}
