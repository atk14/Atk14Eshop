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

	function test_getConversionRate(){
		$czk = Currency::FindByCode("CZK");
		$eur = Currency::GetInstanceByCode("EUR");
		$tomorrow = Date::Tomorrow()->toString();

		CurrencyRate::CreateNewRecord([
			"currency_id" => $czk,
			"rate" => 1,
		]);

		CurrencyRate::CreateNewRecord([
			"currency_id" => $eur,
			"rate" => 25,
		]);

		CurrencyRate::CreateNewRecord([
			"currency_id" => $eur,
			"rate" => 24,
			"rate_date" => "$tomorrow 12:00:00",
		]);

		$this->assertEquals(1.0,$czk->getConversionRate());
		$this->assertEquals(25.0,$eur->getConversionRate());

		$this->assertEquals(1.0,$czk->getConversionRate($czk));
		$this->assertEquals(1.0,$eur->getConversionRate($eur));

		$this->assertEquals(0.04,$czk->getConversionRate($eur));
		$this->assertEquals(25.0,$eur->getConversionRate($czk));

		$this->assertEquals(25.0,$eur->getConversionRate($czk,"$tomorrow 11:00:00"));
		$this->assertEquals(0.04,$czk->getConversionRate($eur,"$tomorrow 11:00:00"));

		$this->assertEquals(24.0,$eur->getConversionRate($czk,"$tomorrow 12:00:00"));
		$this->assertEquals(0.041667,round($czk->getConversionRate($eur,"$tomorrow 12:00:00"),6));
	}
}
