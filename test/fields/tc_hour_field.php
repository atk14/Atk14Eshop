<?php
class TcHourField extends TcBase {

	function test(){
		$this->field = new HourField(["required" => false]);

		$value = $this->assertValid("1:00");
		$this->assertEquals(1.0,$value);

		$value = $this->assertValid("12:30");
		$this->assertEquals(12.5,$value);

		$value = $this->assertValid("23:59");
		$this->assertEquals(23.983333333333,$value);

		$value = $this->assertValid("00:00");
		$this->assertTrue(0.0 === $value);

		$value = $this->assertValid("");
		$this->assertTrue(null === $value);

		$value = $this->assertValid(" ");
		$this->assertTrue(null === $value);

		$this->assertInvalid("24:00");
		$this->assertInvalid("24:01");

		// allow 24:00 time

		$this->field = new HourField(["allow_2400" => true]);

		$value = $this->assertValid("24:00");
		$this->assertEquals(24.00,$value);

		$this->assertInvalid("24:01");
	}
}
