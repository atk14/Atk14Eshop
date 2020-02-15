<?php
class TcReverseBooleanField extends TcBase {

	function test(){
		$this->field = new ReverseBooleanField(array("required" => false));

		$value = $this->assertValid(""); 
		$this->assertEquals(true,$value);
		
		$value = $this->assertValid("on"); 
		$this->assertEquals(false,$value);
	}

	function test_widget(){
		$form = new Atk14Form();

		$form->add_field("b", new ReverseBooleanField(array()));
		$field = $form->get_field("b");
		$this->assertEquals('<input class="form-check-input" id="id_b" type="checkbox" name="b" />',$field->as_widget());

		$form->add_field("b", new ReverseBooleanField(array("initial" => false)));
		$field = $form->get_field("b");
		$this->assertEquals('<input class="form-check-input" id="id_b" type="checkbox" name="b" checked="checked" />',$field->as_widget());

		$form->add_field("b", new ReverseBooleanField(array("initial" => true)));
		$field = $form->get_field("b");
		$this->assertEquals('<input class="form-check-input" id="id_b" type="checkbox" name="b" />',$field->as_widget());
	}
}
