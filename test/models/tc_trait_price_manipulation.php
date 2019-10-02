<?php
class PriceManipulation {
	use TraitPriceManipulation;
}

class TcTraitPriceManipulation extends TcBase {

	function test__addVat(){
		$pm = new PriceManipulation();

		$this->assertEquals(242.0,$pm->_addVat(200.0,21.0));
		$this->assertEquals(242.0,$pm->_addVat(200.0,21.0,true));
		$this->assertEquals(200.0,$pm->_addVat(200.0,21.0,false));

		$this->assertEquals(200.0,$pm->_addVat(200.0,null));
		$this->assertEquals(200.0,$pm->_addVat(200.0,null,true));
		$this->assertEquals(200.0,$pm->_addVat(200.0,null,false));
	}

	function test__removeVat(){
		$pm = new PriceManipulation();

		$this->assertEquals(200.0,$pm->_removeVat(242.0,21.0));
		$this->assertEquals(200.0,$pm->_removeVat(242.0,21.0,false));
		$this->assertEquals(242.0,$pm->_removeVat(242.0,21.0,true));

		$this->assertEquals(242.0,$pm->_removeVat(242.0,null));
		$this->assertEquals(242.0,$pm->_removeVat(242.0,null,false));
		$this->assertEquals(242.0,$pm->_removeVat(242.0,null,true));
	}
}
