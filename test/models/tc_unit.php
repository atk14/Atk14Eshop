<?php
class TcUnit extends TcBase {

	function test(){
		$pcs = Unit::GetInstanceById(1);

		$this->assertEquals('pcs',$pcs->getUnitLocalized());
		$this->assertEquals('pcs',"$pcs");

		$lang = "cs";
		Atk14Locale::Initialize($lang);

		$this->assertEquals('ks',$pcs->getUnitLocalized());
		$this->assertEquals('ks',"$pcs");
	}

	function test_getUnitPriceRoundingPrecision(){
		$pcs = Unit::FindByUnit("pcs");
		$this->assertEquals(2,$pcs->getUnitPriceRoundingPrecision());

		$cm = Unit::FindByUnit("cm");
		$this->assertEquals(4,$cm->getUnitPriceRoundingPrecision());
	}
}
