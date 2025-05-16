<?php
class TcPickerableDateField extends TcBase {

	function test(){
		$this->field = new PickerableDateField();

		$value = $this->assertValid("2023-12-22");
		$this->assertEquals("2023-12-22",$value);

		$value = $this->assertValid("12/21/2023");
		$this->assertEquals("2023-12-21",$value);

		$value = $this->assertValid(" 2023-12-24 12:33 ");
		$this->assertEquals("2023-12-24",$value);

		$err_msg = $this->assertInvalid("2023-12-33");
		$this->assertEquals("Enter a valid date.",$err_msg);

		$err_msg = $this->assertInvalid("nonsence");
		$this->assertEquals("Enter a valid date.",$err_msg);
	}

	function test_rendering(){
		$form = new Atk14Form();
		$form["date"] = new PickerableDateField(array(
			"initial" => "2023-12-33 10:51:10",
		));

		$this->assertEquals('<input required="required" type="date" name="date" class="date text form-control" id="id_date" value="2023-12-33" />',$form["date"]->as_widget());
	}
}
