<?php
class TcLocalVatNumberField extends TcBase {

	function test(){
		$this->field = new LocalVatNumberField([]);

		$value = $this->assertValid("2034567890");
		$this->assertEquals("2034567890",$value);

		$err_msg = $this->assertInvalid("5534567890");
		$this->assertEquals("Enter a valid value.",$err_msg);
	}
}
