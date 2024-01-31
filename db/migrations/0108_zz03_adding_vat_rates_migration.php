<?php
class Zz03AddingVatRatesMigration extends ApplicationMigration {

	function up(){
		VatRate::FindByVatPercent(12.0) ||
		VatRate::CreateNewRecord([
			"code" => "reduced_12",
			"vat_percent" => 12.0,
			"name_cs" => "snížená sazba DPH 12%",
			"name_en" => "reduced VAT rate 12%",
		]);

		VatRate::FindByVatPercent(0.0) ||
		VatRate::CreateNewRecord([
			"code" => "zero",
			"vat_percent" => 0.0,
			"name_cs" => "nulová sazba DPH",
			"name_en" => "zero VAT rate",
		]);
	}
}
