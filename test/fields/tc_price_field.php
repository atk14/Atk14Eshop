<?php
class TcPriceField extends TcBase {
	
	function test(){
		$lang = "cs";
		Atk14Locale::Initialize($lang);

		$this->field = $f = new PriceField();

		$price = $this->assertValid("123");
		$this->assertEquals(123.0,$price);

		$price = $this->assertValid("123.4");
		$this->assertEquals(123.4,$price);

		$price = $this->assertValid("123,45");
		$this->assertEquals(123.45,$price);

		$price = $this->assertValid("1 222 123,45");
		$this->assertEquals(1222123.45,$price);

		$price = $this->assertValid("1'222'123.88");
		$this->assertEquals(1222123.88,$price);
	}
}
