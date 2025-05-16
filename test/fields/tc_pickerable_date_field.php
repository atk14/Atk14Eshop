<?php
class TcPickerableDateField extends TcBase {

	function test(){
		$this->field = new PickerableDateField();

		$val = $this->assertValid("2025-01-31");
		$this->assertEquals("2025-01-31",$val);

		$val = $this->assertValid("03/31/2025");
		$this->assertEquals("2025-03-31",$val);

		$err = $this->assertInvalid("nonsence");
		$this->assertEquals("Enter a valid date.",$err);
	}
}
