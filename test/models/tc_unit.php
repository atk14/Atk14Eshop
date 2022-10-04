<?php
/**
 *
 * @fixture currencies
 */
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
		$bitcoin = Currency::GetInstanceByCode("BTC");
		$czk = Currency::GetInstanceByCode("CZK");

		$pcs = Unit::FindByUnit("pcs");
		$this->assertEquals(2,$pcs->getUnitPriceRoundingPrecision()); // default currency
		$this->assertEquals(2,$pcs->getUnitPriceRoundingPrecision($czk));
		$this->assertEquals(8,$pcs->getUnitPriceRoundingPrecision($bitcoin));

		$cm = Unit::FindByUnit("cm");
		$this->assertEquals(4,$cm->getUnitPriceRoundingPrecision()); // default currency
		$this->assertEquals(4,$cm->getUnitPriceRoundingPrecision($czk));
		$this->assertEquals(10,$cm->getUnitPriceRoundingPrecision($bitcoin));
	}
}
