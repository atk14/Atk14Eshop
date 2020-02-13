<?php
class TcMyVies extends TcBase {

	function test(){
		$mv = new MyVies();
		$this->assertEquals("CZ12345678",$mv->filterVat("CZ 1234-5678"));
	}
}
