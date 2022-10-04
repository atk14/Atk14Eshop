<?php
class TcCurrency extends TcBase {

	function test(){
		$def = Currency::GetDefaultCurrency();
		$this->assertEquals("CZK",$def->getCode());
		$this->assertEquals("CZK","$def");
		$this->assertEquals("CZK",$def->getSymbol());
		$this->assertEquals(true,$def->isDefaultCurrency());

		$eur = Currency::GetInstanceByCode("EUR");
		$this->assertEquals("EUR",$eur->getCode());
		$this->assertEquals("EUR","$eur");
		$this->assertEquals("EUR",$eur->getSymbol());
		$this->assertEquals(false,$eur->isDefaultCurrency());

		$lang = "cs";
		Atk14Locale::Initialize($lang);

		$this->assertEquals("CZK","$def");
		$this->assertEquals("Kč",$def->getSymbol());

		$this->assertEquals("EUR","$eur");
		$this->assertEquals("EUR",$eur->getSymbol());
	}

	function test_rounding_prices(){
		$czk = Currency::FindByCode("CZK");
		$this->assertEquals(null,$czk->roundPrice(null));
		$this->assertEquals(123.34,$czk->roundPrice(123.34));
		$this->assertEquals(123.35,$czk->roundPrice(123.345));
		$this->assertEquals(123.35,$czk->roundPrice(123.345,PHP_ROUND_HALF_UP));
		$this->assertEquals(123.34,$czk->roundPrice(123.345,PHP_ROUND_HALF_DOWN));
		$this->assertEquals(123,$czk->roundSummaryPrice(122.5));
		$this->assertEquals(123,$czk->roundSummaryPrice(122.5,PHP_ROUND_HALF_UP));
		$this->assertEquals(122,$czk->roundSummaryPrice(122.5,PHP_ROUND_HALF_DOWN));
		$this->assertEquals(null,$czk->roundPrice(null));
		$this->assertEquals(null,$czk->roundSummaryPrice(null));

		$eur = Currency::FindByCode("EUR");
		$this->assertEquals(123.34,$eur->roundPrice(123.34));
		$this->assertEquals(123.35,$eur->roundPrice(123.345));
		$this->assertEquals(123.35,$eur->roundSummaryPrice(123.345));
		$this->assertEquals(null,$eur->roundPrice(null));
		$this->assertEquals(null,$eur->roundSummaryPrice(null));

		$pcs = Unit::FindByUnit("pcs");
		$this->assertEquals(1,$pcs->getDisplayUnitMultiplier());
		$this->assertEquals(1.23,$czk->roundUnitPrice(1.23456,$pcs));

		$cm = Unit::FindByUnit("cm");
		$this->assertEquals(100,$cm->getDisplayUnitMultiplier());
		$this->assertEquals(1.2346,$czk->roundUnitPrice(1.23456,$cm));
		$this->assertEquals(1.2346,$czk->roundUnitPrice(1.23456,$cm,PHP_ROUND_HALF_UP));
		$this->assertEquals(1.2345,$czk->roundUnitPrice(1.23455,$cm,PHP_ROUND_HALF_DOWN));
	}
}
