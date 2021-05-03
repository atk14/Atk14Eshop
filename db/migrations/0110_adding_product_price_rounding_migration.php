<?php
/**
 * Vytvori spec. produkt pro ulozeni zaokrouhleni (jako polozky) do objednavky.
 */
class AddingProductPriceRoundingMigration extends ApplicationMigration {

	function up(){
		$card = Card::CreateNewRecord([
			"name_en" => "Price rounding",
			"name_cs" => "Zaokrouhlení",
			"visible" => false,
			"has_variants" => false,
		]);

		$product = Product::CreateNewRecord([
			"code" => "price_rounding",
			"card_id" => $card,
			"catalog_id" => "000/000000",
			"visible" => false,
			"vat_rate_id" => VatRate::GetInstanceByCode("default"),
			"consider_stockcount" => false,
		]);
	}
}
